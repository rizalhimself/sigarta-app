<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permohonan;

/**
 * 
 *
 * @property int $id
 * @property int $permohonan_id
 * @property string $no_surat
 * @property string $jenis_surat
 * @property string $tgl_surat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Permohonan $permohonan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat whereJenisSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat whereNoSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat wherePermohonanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat whereTglSurat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Surat extends Model
{
    //definisi eksplisit nama tabel (penting!)
    protected $table = 'surat';

    //kolom yang dapat diisi
    protected $fillable = [
        'permohonan_id',
        'no_surat',
        'jenis_surat',
        'tgl_surat',
    ];

    // relasi ke tabel permohonan
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

}
