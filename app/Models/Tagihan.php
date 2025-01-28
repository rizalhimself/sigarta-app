<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $penghuni_rumah_id
 * @property int $bulan
 * @property int $tahun
 * @property string $jenis_tagihan
 * @property string $nominal
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PenghuniRumah $penghuni_rumah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereJenisTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereNominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan wherePenghuniRumahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tagihan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tagihan extends Model
{
    // definisi eksplisit nama tabel
    protected $table = 'tagihan';

    protected $fillable = [
        'penghuni_rumah_id',
        'bulan',
        'tahun',
        'jenis_tagihan',
        'nominal',
        'status',
    ];

    public function penghuni_rumah()
    {
        return $this->belongsTo(PenghuniRumah::class, 'penghuni_rumah_id');
    }
}
