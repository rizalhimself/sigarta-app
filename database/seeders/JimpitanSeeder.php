<?php

namespace Database\Seeders;

use App\Models\Jimpitan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JimpitanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tambahkan data dummy
        Jimpitan::create([
            'penghuni_rumah_id' => 1,
            'tanggal' => Carbon::now()->subDays(5),
            'jumlah' => 20000,
        ]);

        Jimpitan::create([
            'penghuni_rumah_id' => 1,
            'tanggal' => Carbon::now()->subDays(3),
            'jumlah' => 18000,
        ]);

        Jimpitan::create([
            'penghuni_rumah_id' => 2,
            'tanggal' => Carbon::now()->subDays(2),
            'jumlah' => 25000,
        ]);
    }

}
