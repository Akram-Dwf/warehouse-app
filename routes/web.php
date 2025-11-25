<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Master Data: Kategori (Admin & Manager)
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
        ->middleware('role:admin|manager');
    // Master Data: Produk (Admin & Manager)
    Route::resource('products', ProductController::class)
        ->middleware('role:admin|manager');
});

require __DIR__ . '/auth.php';
