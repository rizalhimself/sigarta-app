<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $nik
 * @property string $nama_lengkap
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $jenis_kelamin
 * @property string|null $golongan_darah
 * @property string $agama
 * @property string $status_perkawinan
 * @property string $pekerjaan
 * @property string $kewarganegaraan
 * @property string $no_telfon
 * @property string|null $link_foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HasilRapat> $hasilRapat
 * @property-read int|null $hasil_rapat_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KasMasuk> $kasMasuk
 * @property-read int|null $kas_masuk_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laporan> $laporan
 * @property-read int|null $laporan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PenghuniRumah> $penghuniRumah
 * @property-read int|null $penghuni_rumah_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permohonan> $permohonan
 * @property-read int|null $permohonan_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereGolonganDarah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereKewarganegaraan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereLinkFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereNoTelfon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga wherePekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereStatusPerkawinan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereTglLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereUserId($value)
 * @mixin \Eloquent
 */
class Warga extends Model
{
    //nama tabel
    protected $table = 'warga';

    //kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'no_telfon',
        'link_foto',
    ];

    // relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // relasi ke tabel kas_masuk
    public function kasMasuk()
    {
        return $this->hasMany(KasMasuk::class, 'warga_id');
    }

    // relasi ke tabel permohonan
    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'warga_id');
    }

    // relasi ke tabel laporan
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'warga_id');
    }

    // relasi ke tabel hasil_rapat
    public function hasilRapat()
    {
        return $this->hasMany(HasilRapat::class, 'no_rumah', 'no_rumah');
    }

    // relasi ke tabel penghuni_rumah
    public function penghuniRumah()
    {
        return $this->hasMany(PenghuniRumah::class, 'warga_id');
    }

    // relasi ke tabel wisata
    public function wisata()
    {
        return $this->hasMany(Wisata::class, 'warga_id');
    }
}
