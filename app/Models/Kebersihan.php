<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kebersihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kebersihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kebersihan query()
 * @mixin \Eloquent
 */
class Kebersihan extends Model
{
    // definisi eksplisit nama tabel
    protected $table = 'kebersihan';

    protected $fillable = [
        'penghuni_rumah_id'
    ];

    public function penghuni_rumah()
    {
        return $this->belongsTo(PenghuniRumah::class, 'penghuni_rumah_id');
    }
}
