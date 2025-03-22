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
        Schema::table('penghuni_rumah', function (Blueprint $table) {
            //hapus kolom yang tidak diperlukan
            $table->dropForeign(['keluarga_id']);
            $table->dropColumn('keluarga_id');
            $table->renameColumn('status', 'status_penghuni');
            $table->enum('status_penghuni', ['Pemilik', 'Kontrak', 'Menginap'])->change();
            $table->date('tanggal_mulai')->nullable()->after('status_penghuni');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penghuni_rumah', function (Blueprint $table) {
            $table->foreignId('keluarga_id')->nullable()->constrained('keluarga')->nullOnDelete();
            $table->renameColumn('status_penghuni', 'status');
            $table->enum('status', ['Kepala Keluarga', 'Anggota Keluarga', 'Penghuni Lain'])->change();
            $table->dropColumn('tanggal_mulai');
            $table->dropColumn('tanggal_selesai');
        });
    }
};
