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
        Schema::create('restocks', function (Blueprint $table) {
            $table->id();
            
            $table->string('po_number')->unique();
            $table->date('date');
            $table->date('expected_delivery_date')->nullable();
            
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('supplier_id')->constrained('users');
            
            $table->enum('status', ['pending', 'confirmed', 'in_transit', 'received'])->default('pending');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
