<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $warga_id
 * @property int $rumah_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warga $kepalaKeluarga
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenghuniRumah> $penghuniRumah
 * @property-read int|null $penghuni_rumah_count
 * @property-read \App\Models\Rumah $rumah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga whereRumahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keluarga whereWargaId($value)
 * @mixin \Eloquent
 */
class Keluarga extends Model
{
    // definisi eksplisi nama tabel (penting!)
    protected $table = 'keluarga';

    protected $fillable = [
        'warga_id',
        'rumah_id',
    ];

    public function kepalaKeluarga ()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function penghuniRumah()
    {
        return $this->hasMany(PenghuniRumah::class, 'keluarga_id');
    }
}
