<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'tenant_slug' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'password.required' => 'Le mot de passe est requis.',
            'tenant_slug.required' => 'Le slug du locataire est requis.',
            'tenant_slug.string' => 'Le slug du locataire doit être une chaîne de caractères.',
        ];
    }
}