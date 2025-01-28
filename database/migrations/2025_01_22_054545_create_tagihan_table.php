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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghuni_rumah_id')->constrained('penghuni_rumah')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->string('jenis_tagihan');
            $table->decimal('nominal', 10, 2);
            $table->enum('status', ['Tertagih', 'Lunas'])->default('Tertagih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
