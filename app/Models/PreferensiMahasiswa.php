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
        'kriteria_jenis_magang_id',
        'kriteria_open_remote_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function kriteriaPekerjaan()
    {
        return $this->belongsTo(KriteriaPekerjaan::class);
    }

    public function kriteriaBidangIndustri()
    {
        return $this->belongsTo(KriteriaBidangIndustri::class);
    }

    public function kriteriaLokasiMagang()
    {
        return $this->belongsTo(KriteriaLokasiMagang::class);
    }

    public function kriteriaJenisMagang()
    {
        return $this->belongsTo(KriteriaJenisMagang::class);
    }

    public function kriteriaOpenRemote()
    {
        return $this->belongsTo(KriteriaOpenRemote::class);
    }
}
