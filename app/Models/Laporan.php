<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $warga_id
 * @property string $tgl_laporan
 * @property string $jenis_laporan
 * @property string|null $foto
 * @property string|null $keterangan
 * @property string $status
 * @property string|null $tanggapan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warga $warga
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereJenisLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereTanggapan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereTglLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laporan whereWargaId($value)
 * @mixin \Eloquent
 */
class Laporan extends Model
{
    // Definisi eksplisit nama tabel (penting!)
    protected $table = 'laporan';

    // Kolom yang dapat diisi
    protected $fillable = [
        'warga_id',
        'tgl_laporan',
        'jenis_laporan',
        'foto',
        'keterangan',
        'status',
        'tanggapan'
        
    ];

    // Relasi ke model Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
