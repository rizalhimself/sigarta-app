<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arisan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arisan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arisan query()
 * @mixin \Eloquent
 */
class Arisan extends Model
{
    // definisi eksplisit nama tabel
    protected $table = 'arisan';

    protected $fillable = [
        'penghuni_rumah_id'
    ];

    // relasi dengan tabel penghuni rumah
    public function penghuni_rumah()
    {
        return $this->belongsTo(PenghuniRumah::class, 'penghuni_rumah_id');
    }
}
