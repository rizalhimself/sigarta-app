<?php

namespace App\Models;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $warga_id
 * @property string $jenis_permohonan
 * @property string $tgl_permohonan
 * @property string $status
 * @property string|null $link_berkas
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Warga $warga
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereJenisPermohonan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereLinkBerkas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereTglPermohonan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permohonan whereWargaId($value)
 * @mixin \Eloquent
 */
class Permohonan extends Model
{
    // Definisi eksplisit nama tabel (penting!)
    protected $table = 'permohonan';

    // Kolom yang dapat diisi
    protected $fillable = [
        'warga_id',
        'jenis_permohonan',
        'tgl_permohonan',
        'status',
        'link_berkas',
        'keterangan',
    ];

    // Relasi ke model Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
