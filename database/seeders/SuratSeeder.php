<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Surat;
use App\Models\Permohonan;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //tambahan data dummy ke tabel permohonan
        $permohonan = Permohonan::create([
            'warga_id' => 1,
            'jenis_permohonan' => 'Surat',
            'tgl_permohonan' => date(now()),
            'status' => '',
            'link_berkas' => 'https://example.com/berkas.pdf',
            'keterangan' => 'Permohonan surat keterangan usaha',
        ]);

        //tambahan data dummy ke tabel surat
        $surat = Surat::create([
            'permohonan_id' => $permohonan->id,
            'no_surat' => '001/SKU/2021',
            'jenis_surat' => 'Surat Keterangan Usaha',
            'tgl_surat' => date(now())
        ]);

    }
}
