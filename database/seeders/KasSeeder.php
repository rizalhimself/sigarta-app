<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\LaporanCashFlow;
use App\Models\Warga;
use App\Models\User;
use Carbon\Carbon;

class KasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Tambahkan user dummy terlebih dahulu
        $user = User::create([
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'), // Enkripsi password
            'role' => 'warga',
        ]);

        $user1 = User::create([
            'username' => 'rizalhimself',
            'email' => 'rizalhimself@example.com',
            'password' => bcrypt('password123'),
            'role' => 'ketua',
        ]);

        $user2 = User::create([
            'username' => 'teddybear',
            'email' => 'teddybear@example.com',
            'password' => bcrypt('password123'),
            'role' => 'sekretaris',
        ]);

        $user3 = User::create([
            'username' => 'miakhalifa',
            'email' => 'miakhalifa@example.com',
            'password' => bcrypt('password123'),
            'role' => 'bendahara',
        ]);

        $user4 = User::create([
            'username' => 'supangat',
            'email' => 'supangat@example.com',
            'password' => bcrypt('password456'),
            'role' => 'warga',
        ]);

        $user5 = User::create([
            'username' => 'asiah',
            'email' => 'asiah@example.com',
            'password' => bcrypt('password789'),
            'role' => 'warga',
        ]);

        $user6 = User::create([
            'username' => 'karenwalker',
            'email' => 'karenwalker@example.com',
            'password' => bcrypt('securepassword'),
            'role' => 'warga',
        ]);

        $user7 = User::create([
            'username' => 'tonystark',
            'email' => 'tonystark@example.com',
            'password' => bcrypt('ironman'),
            'role' => 'warga',
        ]);

        $user8 = User::create([
            'username' => 'steverogers',
            'email' => 'steverogers@example.com',
            'password' => bcrypt('captainamerica'),
            'role' => 'warga',
        ]);

        $user9 = User::create([
            'username' => 'brucewayne',
            'email' => 'brucewayne@example.com',
            'password' => bcrypt('batman123'),
            'role' => 'warga',
        ]);

        $user10 = User::create([
            'username' => 'clarkkent',
            'email' => 'clarkkent@example.com',
            'password' => bcrypt('superman456'),
            'role' => 'warga',
        ]);


        // Tambahkan warga dummy dengan user_id yang baru saja dibuat
        $warga = Warga::create([
            'user_id' => $user->id,  // Foreign key dari tabel users
            'nik' => '1234567890123456',
            'nama_lengkap' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tgl_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'golongan_darah' => 'O',
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Pegawai Swasta',
            'kewarganegaraan' => 'Indonesia',
            'no_telfon' => '081234567890',
            'link_foto' => 'https://example.com/avatar.jpg',
        ]);

        $warga1 = Warga::create([
            'user_id' => $user1->id,
            'nik' => '1234567890123457',
            'nama_lengkap' => 'Rizal Himself',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => '1991-02-02',
            'jenis_kelamin' => 'L',
            'golongan_darah' => 'A',
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Pegawai Negeri',
            'kewarganegaraan' => 'Indonesia',
            'no_telfon' => '081234567891',
            'link_foto' => 'https://example.com/avatar1.jpg',
        ]);

        $warga2 = Warga::create([
            'user_id' => $user2->id,
            'nik' => '1234567890123458',
            'nama_lengkap' => 'Teddy Bear',
            'tempat_lahir' => 'Surabaya',
            'tgl_lahir' => '1992-03-03',
            'jenis_kelamin' => 'L',
            'golongan_darah' => 'B',
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Pegawai BUMN',
            'kewarganegaraan' => 'Indonesia',
            'no_telfon' => '081234567892',
            'link_foto' => 'https://example.com/avatar2.jpg',
        ]);

        $warga3 = Warga::create([
            'user_id' => $user3->id,
            'nik' => '1234567890123459',
            'nama_lengkap' => 'Mia Khalifa',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => '1993-04-04',
            'jenis_kelamin' => 'P',
            'golongan_darah' => 'AB',
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Pegawai BUMN',
            'kewarganegaraan' => 'Indonesia',
            'no_telfon' => '081234567893',
            'link_foto' => 'https://example.com/avatar3.jpg',
        ]);

        // Insert data Kas Masuk
        $kasMasuk1 = KasMasuk::create([
            'warga_id' => $warga->id,
            'tgl_pemasukan' => Carbon::now()->subDays(10)->format('Y-m-d'),
            'nominal' => 150000.00,
            'jenis_transaksi' => 'Iuran Bulanan',
            'keterangan' => 'Pembayaran iuran Januari',
        ]);

        $kasMasuk2 = KasMasuk::create([
            'warga_id' => $warga->id,
            'tgl_pemasukan' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'nominal' => 200000.00,
            'jenis_transaksi' => 'Kas Sosial',
            'keterangan' => 'Dana kegiatan sosial',
        ]);

        // Insert data Kas Keluar
        $kasKeluar1 = KasKeluar::create([
            'tgl_pengeluaran' => Carbon::now()->subDays(3)->format('Y-m-d'),
            'nominal' => 100000.00,
            'jenis_transaksi' => 'Operasional',
            'keterangan' => 'Pembelian alat kebersihan',
        ]);

        $kasKeluar2 = KasKeluar::create([
            'tgl_pengeluaran' => Carbon::now()->format('Y-m-d'),
            'nominal' => 50000.00,
            'jenis_transaksi' => 'Acara RT',
            'keterangan' => 'Biaya konsumsi acara warga',
        ]);

        // Cek laporan cash flow yang telah otomatis terbuat oleh event model
        $laporan = LaporanCashFlow::all();
        echo "Laporan Cash Flow:\n";
        foreach ($laporan as $lapor) {
            echo "Tanggal: " . $lapor->tgl_transaksi . " | Jenis: " . $lapor->jenis_transaksi .
                 " | Nominal: " . $lapor->nominal . " | Saldo: " . $lapor->saldo . "\n";
        }
    }
}
