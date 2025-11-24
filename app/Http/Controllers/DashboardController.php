<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin') {
            return view('dashboard.admin');
        } 
        
        if ($role == 'manager') {
            return view('dashboard.manager');
        } 
        
        if ($role == 'staff') {
            return view('dashboard.staff');
        } 
        
        if ($role == 'supplier') {
            return view('dashboard.supplier');
        }

        // Jika role tidak dikenali (fallback)
        return view('dashboard');
    }
}