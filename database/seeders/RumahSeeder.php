<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rumah;

class RumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tambah data dummy ke tabel rumah
        Rumah::create([
            'no_rumah' => 'A1',
            'pemilik_id' => 1,
            'alamat' => 'Jl. Raya No. 1',
            'keterangan' => 'Rumah besar dengan halaman luas',
            'link_foto' => 'https://example.com/foto.jpg'
        ]);

        Rumah::create([
            'no_rumah' => 'A2',
            'pemilik_id' => 2,
            'alamat' => 'Jl. Raya No. 2',
            'keterangan' => 'Rumah kecil dengan halaman sempit',
            'link_foto' => 'https://example.com/foto.jpg'
        ]);
    }
}
