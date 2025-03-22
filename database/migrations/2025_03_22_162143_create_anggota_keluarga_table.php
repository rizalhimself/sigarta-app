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
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluarga')->onDelete('cascade');
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->enum('status_hubungan', ['Suami','Istri','Anak','Famili Lain']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};
