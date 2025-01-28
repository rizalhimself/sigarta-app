<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $rumah_id
 * @property string $jenis_rapat
 * @property string $tgl_rapat
 * @property string $agenda
 * @property string $notulensi
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Rumah $rumah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereAgenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereJenisRapat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereNotulensi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereRumahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereTglRapat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilRapat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HasilRapat extends Model
{
    // Definisi eksplisit nama tabel (penting!)
    protected $table = 'hasil_rapat';

    // Kolom yang dapat diisi
    protected $fillable = [
        'rumah_id',
        'jenis_rapat',
        'tgl_rapat',
        'agenda',
        'notulensi',
        'keterangan',
    ];

    //relasi ke tabel rumah
    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }
}
