<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public static $visiblePermissions = [
        'index'=>'Dashboard'
    ];
    
    public function index()
    {
        return view('backend.dashboard');
    }
}
