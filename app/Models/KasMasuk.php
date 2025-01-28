<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\LaporanCashFlow;
use App\Models\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int $warga_id
 * @property string $tgl_pemasukan
 * @property string $nominal
 * @property string $jenis_transaksi
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warga $warga
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereJenisTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereNominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereTglPemasukan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KasMasuk whereWargaId($value)
 * @mixin \Eloquent
 */
class KasMasuk extends Model
{
    //definisi eksplisit nama tabel (penting!)
    protected $table = 'kas_masuk';

    protected $fillable = [
        'warga_id',
        'nominal',
        'jenis_transaksi',
        'tgl_pemasukan',
        'keterangan',
    ];

    // relasi ke tabel warga

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    // lifecycle event untuk mencatat ke laporan cash flow
    protected static function booted()
    {
        static::created(function ($kasMasuk){
            // ambil saldo terakhir
            $saldoTerakhir = LaporanCashFlow::latest()->value('saldo') ?? 0;

            //buat catatan ke laporan cash flow
            LaporanCashFlow::create([
                'tgl_transaksi' => Carbon::parse($kasMasuk->tgl_pemasukan),
                'jenis_transaksi' => 'masuk',
                'keterangan' => $kasMasuk->keterangan,
                'nominal' => $kasMasuk->nominal,
                'saldo' => $saldoTerakhir + $kasMasuk->nominal,
            ]);
        });
    }

}
