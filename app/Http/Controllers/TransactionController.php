<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi (Masuk & Keluar).
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'supplier'])->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        
        $suppliers = User::where('role', 'supplier')->get();

        return view('transactions.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:incoming,outgoing',
            'date' => 'required|date',
            
            'supplier_id' => 'required_if:type,incoming|nullable|exists:users,id',
            
            'customer_name' => 'required_if:type,outgoing|nullable|string|max:255',
            
            'notes' => 'nullable|string',
            
            // Validasi Array Produk (Detail Transaksi)
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 2. GENERATE NO REFERENSI OTOMATIS
            $today = date('Ymd');
            $count = Transaction::whereDate('created_at', today())->count() + 1;
            $refNumber = 'TRX-' . $today . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            // 3. SIMPAN HEADER TRANSAKSI
            $transaction = Transaction::create([
                'reference_number' => $refNumber,
                'type' => $validated['type'],
                'date' => $validated['date'],
                'user_id' => Auth::id(), // User yang sedang login (Staff/Manager)
                'supplier_id' => $validated['type'] == 'incoming' ? $validated['supplier_id'] : null,
                'customer_name' => $validated['type'] == 'outgoing' ? $validated['customer_name'] : null,
                'status' => 'pending', 
                'notes' => $validated['notes'],
            ]);

            // 4. SIMPAN DETAIL PRODUK (PIVOT TABLE)
            foreach ($validated['products'] as $item) {
                $transaction->products()->attach($item['id'], [
                    'quantity' => $item['quantity']
                ]);
                
            }

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibuat! Menunggu persetujuan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['products', 'user', 'supplier']);
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Akan kita isi nanti (Edit hanya untuk status Pending)
    }

    /**
     * Memproses Approval (Setujui/Tolak) oleh Manager.
     * Kita gunakan method update untuk mengubah status.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        try {
            DB::beginTransaction();

            if ($request->status == 'approved') {
                
                foreach ($transaction->products as $product) {
                    $qty = $product->pivot->quantity;

                    if ($transaction->type == 'incoming') {
                        $product->increment('stock', $qty);
                    
                    } else {
                        if ($product->stock < $qty) {
                            throw new \Exception("Stok '{$product->name}' tidak cukup! Sisa: {$product->stock}, Diminta: {$qty}");
                        }
                        $product->decrement('stock', $qty);
                    }
                }
            }

            $transaction->update(['status' => $request->status]);

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Status transaksi berhasil diperbarui: ' . ucfirst($request->status));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Gagal! Hanya transaksi status Pending yang bisa dihapus.');
        }

        $user = Auth::user();
        if ($user->role == 'staff' && $transaction->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin menghapus transaksi orang lain.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}