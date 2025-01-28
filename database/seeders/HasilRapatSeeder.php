<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HasilRapat;

class HasilRapatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tambah data dummy ke tabel hasil_rapat
        HasilRapat::create([
            'rumah_id' => 1,
            'jenis_rapat' => 'Rapat Pengurus',
            'tgl_rapat' => date(now()),
            'agenda' => 'Pembahasan Rencana Pembangunan Jalan',
            'notulensi' => 'Rencana pembangunan jalan di depan rumah warga',
            'keterangan' => 'Rapat berjalan dengan lancar'
        ]);

        HasilRapat::create([
            'rumah_id' => '2',
            'jenis_rapat' => 'Rapat Warga',
            'tgl_rapat' => date(now()),
            'agenda' => 'Pembahasan Rencana Pembangunan Jalan',
            'notulensi' => 'Rencana pembangunan jalan di depan rumah warga',
            'keterangan' => 'Rapat berjalan dengan lancar'
        ]);
    }
}
