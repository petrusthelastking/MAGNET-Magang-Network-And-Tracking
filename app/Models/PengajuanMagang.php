<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanMagang extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id', 'lowongan_id', 'dosen_id', 'cv', 'transkrip_nilai', 'portofolio'];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaProfiles::class, 'mahasiswa_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(LowonganMagang::class, 'lowongan_id');
    }

    public function dosen()
    {
        return $this->belongsTo(DosenProfiles::class, 'dosen_id');
    }

    public function logAktivitas()
    {
        return $this->hasMany(logAktivitasMagang::class, 'pengajuan_id');
    }

    public function ulasan()
    {
        return $this->hasOne(UlasanMagang::class, 'pengajuan_id');
    }
}
