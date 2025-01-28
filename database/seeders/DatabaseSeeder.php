<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan seeder secara berurutan
        $this->call([
            KasSeeder::class,
            SuratSeeder::class,
            LaporanSeeder::class,
            RumahSeeder::class,
            KeluargaSeeder::class,
            PenghuniRumahSeeder::class,
            HasilRapatSeeder::class,
            PengumumanSeeder::class,
            JimpitanSeeder::class,
        ]);
    }
}
