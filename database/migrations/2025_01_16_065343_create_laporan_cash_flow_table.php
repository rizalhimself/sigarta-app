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
        Schema::create('laporan_cash_flow', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_transaksi');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']); // jenis transaksi berdasarkan tabel
            $table->text('keterangan');
            $table->decimal('nominal', 10, 2);
            $table->decimal('saldo', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_cash_flow');
    }
};
