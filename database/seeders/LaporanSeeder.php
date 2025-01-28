<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Laporan;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tambah data dummy ke tabel laporan
        Laporan::create([
            'warga_id' => 1,
            'tgl_laporan' => date(now()),
            'jenis_laporan' => 'Kerusakan Jalan',
            'foto' => 'https://example.com/foto.jpg',
            'keterangan' => 'Jalan rusak parah di depan rumah saya',
            'status' => 'selesai',
            'tanggapan' => 'akan segera diperbaiki'
        ]);
    }
}
