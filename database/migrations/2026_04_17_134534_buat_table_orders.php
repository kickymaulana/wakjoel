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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Siapa yang pesan
            $table->text('catatan_khusus')->nullable(); // Misal: "Tanpa kuah", "Sambal banyak"
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->enum('status', ['diproses', 'selesai', 'dibatalkan'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
