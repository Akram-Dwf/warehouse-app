<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestockController extends Controller
{
    /**
     * Menampilkan daftar restock order.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Restock::with(['user', 'supplier'])->latest();

        if ($user->role == 'supplier') {
            $query->where('supplier_id', $user->id);
        }

        $restocks = $query->paginate(10);

        return view('restocks.index', compact('restocks'));
    }

    /**
     * Menampilkan form buat restock baru.
     */
    public function create()
    {
        $products = Product::all();
        
        $suppliers = User::where('role', 'supplier')->get();

        return view('restocks.create', compact('products', 'suppliers'));
    }

    /**
     * Menyimpan restock order baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:date',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $today = date('Ymd');
            $count = Restock::whereDate('created_at', today())->count() + 1;
            $poNumber = 'PO-' . $today . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $restock = Restock::create([
                'po_number' => $poNumber,
                'user_id' => Auth::id(),
                'supplier_id' => $validated['supplier_id'],
                'date' => $validated['date'],
                'expected_delivery_date' => $validated['expected_delivery_date'],
                'status' => 'pending',
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['products'] as $item) {
                $restock->products()->attach($item['id'], [
                    'quantity' => $item['quantity']
                ]);
            }

            DB::commit();

            return redirect()->route('restocks.index')
                ->with('success', 'Restock Order berhasil dibuat! Menunggu konfirmasi Supplier.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail restock order.
     */
    public function show(Restock $restock)
    {
        $restock->load(['products', 'user', 'supplier']);
        
        return view('restocks.show', compact('restock'));
    }

    /**
     * Update status restock (Flow Approval).
     */
    public function update(Request $request, Restock $restock)
    {
        $user = Auth::user();
        $newStatus = $request->status;

        if ($user->role == 'supplier') {
            if ($restock->status != 'pending') {
                return back()->with('error', 'Pesanan ini sudah diproses.');
            }
            if (!in_array($newStatus, ['confirmed', 'rejected'])) {
                return back()->with('error', 'Status tidak valid untuk Supplier.');
            }
        } 
        elseif ($user->role == 'manager' || $user->role == 'admin') {
            if ($newStatus == 'in_transit' && $restock->status != 'confirmed') {
                return back()->with('error', 'Pesanan harus dikonfirmasi supplier dulu.');
            }
            if ($newStatus == 'received' && $restock->status != 'in_transit') {
                return back()->with('error', 'Pesanan harus dalam pengiriman dulu.');
            }
        } else {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah status.');
        }

        $restock->update(['status' => $newStatus]);

        $message = 'Status Restock berhasil diperbarui menjadi: ' . ucfirst($newStatus);
        
        if ($newStatus == 'received') {
            $message .= '. Silakan informasikan Staff untuk membuat Transaksi Masuk.';
        }

        return redirect()->route('restocks.show', $restock)
            ->with('success', $message);
    }

}