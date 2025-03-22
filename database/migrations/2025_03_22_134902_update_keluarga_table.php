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
        Schema::table('keluarga', function (Blueprint $table) {
            $table->dropForeign(['rumah_id']);
            $table->dropColumn('rumah_id');
            $table->dropForeign(['warga_id']);
            $table->renameColumn('warga_id', 'kepala_keluarga_id');
        });

        Schema::table('keluarga', function (Blueprint $table) {
            $table->foreign('kepala_keluarga_id')->references('id')
            ->on('warga')->onDelete('cascade');
            $table->string('link_foto_kk')->nullable()->after('kepala_keluarga_id');
            $table->integer('no_kk')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga', function (Blueprint $table) {
            $table->dropColumn('no_kk');
            $table->dropColumn('link_foto_kk');
            $table->dropForeign(['kepala_keluarga_id']);
            $table->renameColumn('kepala_keluarga_id', 'warga_id');
        });

        Schema::table('keluarga', function (Blueprint $table) {
            $table->foreign('warga_id')->references('id')
            ->on('warga')->onDelete('cascade');
            $table->foreignId('rumah_id')->constrained('rumah')->onDelete('cascade');
        });
    }
};
