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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // 1. Info Dasar
            $table->string('reference_number')->unique();
            $table->enum('type', ['incoming', 'outgoing']);
            $table->date('date');
            
            // 2. Pelaku Transaksi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->foreignId('supplier_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('customer_name')->nullable(); 
            
            // 3. Status & Catatan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
