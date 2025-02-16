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
        Schema::table('warga', function (Blueprint $table) {
            //tambahkan kolom link_foto_ktp

            $table->string('link_foto_ktp')->nullable()->after('link_foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            //hapus kolom link_foto_ktp
            $table->dropColumn('link_foto_ktp');
        });
    }
};
