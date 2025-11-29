<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Restock;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $data = [];

        if ($role == 'admin' || $role == 'manager') {
            $data['total_products'] = Product::count();

            $data['low_stock_products'] = Product::whereColumn('stock', '<=', 'min_stock')->get();

            $data['inventory_value'] = Product::sum(DB::raw('stock * purchase_price'));

            $data['transactions_this_month'] = Transaction::whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->count();
            
            $data['pending_transactions'] = Transaction::where('status', 'pending')->count();

            $data['ongoing_restocks'] = Restock::whereIn('status', ['confirmed', 'in_transit'])->count();
            
            $data['total_users'] = User::count();
            
            if ($role == 'admin') {
                return view('dashboard.admin', compact('data'));
            } else {
                return view('dashboard.manager', compact('data'));
            }
        } 
        
        if ($role == 'staff') {
            $data['my_transactions_today'] = Transaction::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::today())
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