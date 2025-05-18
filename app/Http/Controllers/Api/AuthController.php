<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tenant;

class AuthController extends Controller
{
    public function login(LoginAPIRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'tenant_slug' => 'required|string', // Récupérez le slug du locataire pour la connexion
        ]);

        $tenant = Tenant::where('slug', $request->tenant_slug)->first();

        if (!$tenant) {
            return response()->json(['message' => 'Tenant not found.'], 404);
        }

        // Vérifiez l'utilisateur dans le contexte du locataire
        $user = User::where('email', $request->email)
                    ->where('tenant_id', $tenant->id)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials or user not found for this tenant.'], 401);
        }

        // Créez un token Sanctum pour l'utilisateur
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'tenant' => $tenant
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // Supprime le token courant
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}