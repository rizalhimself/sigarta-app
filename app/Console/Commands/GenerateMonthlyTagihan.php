<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use App\Models\PenghuniRumah;

class GenerateMonthlyTagihan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:tagihan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat tagihan bulanan untuk setiap kepala keluarga';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // tentukan variabel bulan dan tahun
        $bulan = now()->month;
        $tahun = now()->year;

        // daftarkan jenis tagihan dan nominal
        $tagihanItems = [
            'Permatian' => 8000,
            'Kebersihan' => 12000,
            'Wisata' => 10000,
            'Arisan' => 25000
        ];
    }
}
