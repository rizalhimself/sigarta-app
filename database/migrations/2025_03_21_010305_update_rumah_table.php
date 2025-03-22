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
        Schema::table('rumah', function (Blueprint $table) {
            // hapus kolom yang tidak diperlukan
            $table->dropForeign(['pemilik_id']);
            $table->dropColumn('pemilik_id');
            $table->renameColumn('link_foto', 'link_foto_rumah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah', function (Blueprint $table) {

            $table->foreignId('pemilik_id')->nullable()->constrained('warga')->nullOnDelete();
            $table->renameColumn('link_foto_rumah', 'link_foto');
        });
    }
};
