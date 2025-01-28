<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $tgl_transaksi
 * @property string $jenis_transaksi
 * @property string $keterangan
 * @property string $nominal
 * @property string $saldo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow filterBulan($bulan, $tahun)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereJenisTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereNominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereSaldo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereTglTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanCashFlow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LaporanCashFlow extends Model
{
    //definisi eksplisit nama tabel(penting!)
    protected $table = 'laporan_cash_flow';

    //kolom yang dapat diisi
    protected $fillable = [
        'tgl_transaksi',
        'jenis_transaksi',
        'keterangan',
        'nominal',
        'saldo'
    ];

    public function scopeFilterBulan($query, $bulan, $tahun)
    {
        return $query->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun);
    }
}
