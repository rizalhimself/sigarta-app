<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\LaporanCashFlow;

/**
 * 
 *
 * @property int $id
 * @property string $tgl_pengeluaran
 * @property string $nominal
 * @property string $jenis_transaksi
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereJenisTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereNominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereTglPengeluaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasKeluar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KasKeluar extends Model
{
    //definisi eksplisit nama tabel (penting!)
    protected $table = 'kas_keluar';
    protected $fillable = [
        'tgl_pengeluaran',
        'nominal',
        'jenis_transaksi',
        'keterangan'
    ];

    //lifecycle event untuk mencatat ke laporan cash flow
    protected static function booted()
    {
        static::created(function ($kasKeluar) {
            //mencari saldo terakhir
            $saldoTerakhir = LaporanCashFlow::latest()->value('saldo') ?? 0;

            //mencatat ke laporan cash flow
            LaporanCashFlow::create([
                'tgl_transaksi' => Carbon::parse($kasKeluar->tgl_pengeluaran),
                'jenis_transaksi' => 'keluar',
                'keterangan' => $kasKeluar->keterangan,
                'nominal' => $kasKeluar->nominal,
                'saldo' => $saldoTerakhir - $kasKeluar->nominal
            ]);
        });
    }
}
