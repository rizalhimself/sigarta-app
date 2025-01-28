<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wisata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wisata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wisata query()
 * @mixin \Eloquent
 */
class Wisata extends Model
{
    // definisi eksplisit nama tabel
    protected $table = 'wisata';

    protected $fillable = [
        'penghuni_rumah_id',    // kepala keluarga
        'warga_id'              // anggota keluarga yang ikut
    ];

    // relasi ke tabel penghuni_rumah
    public function penghuni_rumah()
    {
        return $this->belongsTo(PenghuniRumah::class, 'penghuni_rumah_id');
    }

    // relasi ke tabel warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
