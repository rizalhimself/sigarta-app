<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keluarga;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat data dummy untuk tabel keluarga
        Keluarga::create([
            'warga_id' => 1,
            'rumah_id' => 1,
        ]);

        Keluarga::create([
            'warga_id' => 2,
            'rumah_id' => 2,
        ]);
    }
}
