<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi: Satu Produk dimiliki oleh Satu Kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    
    /**
     * Relasi N:M ke Transaksi
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'product_transaction')
                    ->withPivot('quantity');
    }

    /**
     * Relasi N:M ke Restock
     */
    public function restocks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Restock::class, 'product_restock')
                    ->withPivot('quantity');
    }
}