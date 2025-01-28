<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenghuniRumah;

class PenghuniRumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tambah data dummy ke tabel penghuni_rumah
        PenghuniRumah::create([
            'rumah_id' => 1,
            'warga_id' => 1,
            'keluarga_id' => 1,
            'status' => 'Kepala Keluarga'
        ]);

        PenghuniRumah::create([
            'rumah_id' => 1,
            'warga_id' => 3,
            'keluarga_id' => 1,
            'status' => 'Anggota Keluarga'
        ]);

        PenghuniRumah::create([
            'rumah_id' => 2,
            'warga_id' => 2,
            'keluarga_id' => 2,
            'status' => 'Kepala Keluarga'
        ]);

        PenghuniRumah::create([
            'rumah_id' => 2,
            'warga_id' => 4,
            'keluarga_id' => 2,
            'status' => 'Anggota Keluarga'
        ]);
    }
}
