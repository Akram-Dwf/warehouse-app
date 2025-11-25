<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // 1. Informasi Dasar
            $table->string('name');
            $table->string('sku')->unique();
            
            // 2. Relasi ke Kategori
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            // 3. Detail Fisik & Lokasi
            $table->text('description')->nullable();
            $table->string('unit')->default('pcs');
            $table->string('location')->nullable();
            
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('selling_price', 15, 2);
            
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(10);
            
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }
};
