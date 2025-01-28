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
        Schema::create('jimpitan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghuni_rumah_id')->constrained('penghuni_rumah')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('jumlah', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jimpitan');
    }
};
