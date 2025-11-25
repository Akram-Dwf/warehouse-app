<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        // Ambil data produk beserta kategorinya (eager loading)
        $products = Product::with('category')->latest()->paginate(10);

        return view('products.index', compact('products'));
    }
}