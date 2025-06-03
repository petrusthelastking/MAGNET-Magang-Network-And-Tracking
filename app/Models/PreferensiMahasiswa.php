<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'preferensi_mahasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'kriteria_pekerjaan_id',
        'kriteria_bidang_industri_id',
        'kriteria_lokasi_magang_id',
        'kriteria_reputasi_perusahaan_id',
        'kriteria_jenis_magang_id',
        'kriteria_open_remote_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pekerjaan()
    {
        return $this->hasOne(KriteriaPekerjaan::class, 'pekerjaan_id');
    }

    public function bidangIndustri()
    {
        return $this->hasOne(KriteriaBidangIndustri::class, 'bidang_industri_id');
    }

    public function lokasiMagang()
    {
        return $this->hasOne(KriteriaLokasiMagang::class, 'lokasi_magang_id');
    }

    public function jenisMagang()
    {
        return $this->hasOne(KriteriaJenisMagang::class, 'jenis_magang_id');
    }

    public function openRemote()
    {
        return $this->hasOne(KriteriaOpenRemote::class, 'open_remote_id');
    }
}
