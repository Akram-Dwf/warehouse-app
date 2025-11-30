<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\Restock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'supplier'])->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form buat transaksi baru.
     */
    public function create(Request $request)
    {
        $products = Product::all();
        $suppliers = User::where('role', 'supplier')->get();

        $restock = null;
        if ($request->has('restock_id')) {
            $restock = Restock::with('products')->find($request->restock_id);
        }

        return view('transactions.create', compact('products', 'suppliers', 'restock'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:incoming,outgoing',
            'date' => 'required|date',
            'supplier_id' => 'required_if:type,incoming|nullable|exists:users,id',
            'customer_name' => 'required_if:type,outgoing|nullable|string|max:255',
            'notes' => 'nullable|string',
            'restock_id' => 'nullable|exists:restocks,id',
            
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $today = date('Ymd');
            $count = Transaction::whereDate('created_at', today())->count() + 1;
            $refNumber = 'TRX-' . $today . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $transaction = Transaction::create([
                'reference_number' => $refNumber,
                'type' => $validated['type'],
                'date' => $validated['date'],
                'user_id' => Auth::id(),
                'supplier_id' => $validated['type'] == 'incoming' ? $validated['supplier_id'] : null,
                'customer_name' => $validated['type'] == 'outgoing' ? $validated['customer_name'] : null,
                'restock_id' => $validated['restock_id'] ?? null,
                'status' => 'pending',
                'notes' => $validated['notes'],
            ]);

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

    public function show(Transaction $transaction)
    {
        $transaction->load(['products', 'user', 'supplier']);
        return view('transactions.show', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);

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
                            throw new \Exception("Stok '{$product->name}' tidak cukup! Sisa: {$product->stock}");
                        }
                        $product->decrement('stock', $qty);
                    }
                }
            }

            $transaction->update(['status' => $request->status]);
            DB::commit();
            
            $statusMsg = $request->status == 'approved' ? 'Disetujui' : 'Ditolak';
            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Status transaksi berhasil diperbarui: ' . $statusMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Gagal! Hanya transaksi status Pending yang bisa dihapus.');
        }

        $user = Auth::user();
        if ($user->role == 'staff' && $transaction->user_id !== $user->id) {
            return redirect()->back()
                ->with('error', 'AKSES DITOLAK: Anda tidak memiliki izin menghapus transaksi milik orang lain.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}