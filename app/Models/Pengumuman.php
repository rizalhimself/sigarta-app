<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $judul
 * @property string $isi
 * @property string $tgl_pengumuman
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereIsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereTglPengumuman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumuman whereUserId($value)
 * @mixin \Eloquent
 */
class Pengumuman extends Model
{
    // Definisi eksplisit nama tabel (penting!)
    protected $table = 'pengumuman';

    // Kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'tgl_pengumuman',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
