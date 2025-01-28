<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tambah data dummy ke tabel pengumuman
        Pengumuman::create([
            'user_id' => 4,
            'judul' => 'Pengumuman Rapat Pengurus',
            'isi' => 'Rapat pengurus akan dilaksanakan pada tanggal 20 Agustus 2021',
            'tgl_pengumuman' => date(now())
        ]);
    }
}
