<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Restock;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $data = [];

        if ($role == 'admin' || $role == 'manager') {
            $data['total_products'] = Product::count();
            $data['total_users'] = User::count();
            
            $data['low_stock_products'] = Product::whereColumn('stock', '<=', 'min_stock')->get();
            
            $data['pending_transactions'] = Transaction::where('status', 'pending')->count();
            
            if ($role == 'admin') {
                return view('dashboard.admin', compact('data'));
            } else {
                return view('dashboard.manager', compact('data'));
            }
        } 
        
        if ($role == 'staff') {
            $data['my_transactions_today'] = Transaction::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->latest()
                ->get();
                
            return view('dashboard.staff', compact('data'));
        } 
        
        if ($role == 'supplier') {
            $data['pending_restocks'] = Restock::where('supplier_id', $user->id)
                ->where('status', 'pending')
                ->latest()
                ->get();

            return view('dashboard.supplier', compact('data'));
        }

        return view('dashboard');
    }
}