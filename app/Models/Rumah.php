<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $no_rumah
 * @property int|null $pemilik_id
 * @property string|null $alamat
 * @property string|null $keterangan
 * @property string|null $link_foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warga|null $pemilik
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenghuniRumah> $penghuni
 * @property-read int|null $penghuni_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereLinkFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereNoRumah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah wherePemilikId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rumah whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rumah extends Model
{
    // Definisi eksplisit nama tabel (penting!)
    protected $table = 'rumah';

    // Kolom yang dapat diisi
    protected $fillable = [
        'no_rumah',
        'pemilik_id',
        'alamat',
        'keterangan',
        'link_foto'
    ];

    // Relasi ke model Warga
    public function pemilik()
    {
        return $this->belongsTo(Warga::class, 'pemilik_id');
    }

    // Relasi ke model PenghuniRumah
    public function penghuni()
    {
        return $this->hasMany(PenghuniRumah::class, 'rumah_id');
    }
}
