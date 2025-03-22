<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $rumah_id
 * @property int $warga_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $keluarga_id
 * @property-read \App\Models\Keluarga|null $keluarga
 * @property-read \App\Models\Rumah $rumah
 * @property-read \App\Models\Warga $warga
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereKeluargaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereRumahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenghuniRumah whereWargaId($value)
 * @mixin \Eloquent
 */
class PenghuniRumah extends Model
{
    // Definisi eksplisit nama tabel (penting!)
    protected $table = 'penghuni_rumah';

    // Kolom yang dapat diisi
    protected $fillable = [
        'rumah_id',
        'warga_id',
        'status_penghuni',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    // Relasi ke model Rumah
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id', 'id');
    }

    // Relasi ke model Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }


    // relasi ke model kebersihan
    public function kebersihan()
    {
        return $this->hasOne(Kebersihan::class, 'penghuni_rumah_id');
    }

    // relasi ke model arisan
    public function arisan()
    {
        return $this->hasOne(Arisan::class, 'penghuni_rumah_id');
    }

    // relasi ke model wisata
    public  function wisata()
    {
        return $this->hasMany(Wisata::class, 'penghuni_rumah_id');
    }

}
