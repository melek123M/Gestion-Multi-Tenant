<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = App::get('currentTenant');
        return view('dashboard.index', [
            'tenant' => $tenant
        ]);
    }
}
