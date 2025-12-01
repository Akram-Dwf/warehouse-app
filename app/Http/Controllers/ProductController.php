<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // 1. SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // 2. FILTER KATEGORI
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. FILTER STATUS STOK
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'out_of_stock') {
                $query->where('stock', 0);
            } elseif ($request->stock_status == 'low_stock') {
                $query->whereColumn('stock', '<=', 'min_stock')->where('stock', '>', 0);
            } elseif ($request->stock_status == 'available') {
                $query->whereColumn('stock', '>', 'min_stock');
            }
        }

        // 4. SORTING 
        $sort = $request->get('sort', 'created_at'); 
        $direction = $request->get('direction', 'desc'); 

        $allowedSorts = ['name', 'stock', 'selling_price', 'created_at'];
        $allowedDirections = ['asc', 'desc'];

        if (in_array($sort, $allowedSorts) && in_array($direction, $allowedDirections)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest(); 
        }

        $products = $query->paginate(10)->appends($request->all());
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:255|unique:products,sku',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk beserta riwayat transaksinya.
     */
    public function show(Product $product)
    {
        $product->load('category');

        $lastTransactions = $product->transactions()
                                    ->with('user')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('products.show', compact('product', 'lastTransactions'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Memproses update produk.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        if ($product->stock > 0) {
            return redirect()->back()
                ->with('error', 'Gagal hapus! Produk masih memiliki stok ' . $product->stock . ' ' . $product->unit);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}