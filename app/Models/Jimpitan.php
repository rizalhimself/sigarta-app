<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $penghuni_rumah_id
 * @property string $tanggal
 * @property string $jumlah
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PenghuniRumah $penghuni_rumah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan wherePenghuniRumahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jimpitan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Jimpitan extends Model
{
    // definisi eksplisit nama tabel
    protected $table = 'jimpitan';

    protected $fillable = [
        'penghuni_rumah_id',
        'tanggal',
        'jumlah',
    ];

    public function penghuni_rumah()
    {
        return $this->belongsTo(PenghuniRumah::class, 'penghuni_rumah_id');
    }

    protected static function booted()
    {
        static::created(function ($jimpitan) {
            // pencatatan otomatis ke kas masuk
            KasMasuk::create([
                'warga_id' => $jimpitan->penghuni_rumah->warga_id,
                'tgl_pemasukan' => $jimpitan->tanggal,
                'nominal' => $jimpitan->jumlah,
                'jenis_transaksi' => 'Jimpitan',
                'keterangan' => 'Pembayaran Jimpitan Harian'
            ]);
        });
    }
}
