<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_pulsa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nomor');            // Nomor HP tujuan
            $table->integer('jumlah');          // Nominal pulsa
            $table->timestamps();               // created_at = waktu transaksi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_pulsa');
    }
};
