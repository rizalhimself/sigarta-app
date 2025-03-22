<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    //definisi eksplisit nama tabel
    protected $table = 'anggota_keluarga';

    protected $fillable = [
        'keluarga_id',
        'warga_id',
        'status_hubungan'
    ];

    //relasi ke tabel keluarga
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id', 'id');
    }

    //relasi ke tabel warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'id');
    }
}
