<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganMagang extends Model
{
    use HasFactory;

    protected $table = 'lowongan_magang';

    protected $fillable = [
        'nama',
        'kuota',
        'pekerjaan_id',
        'deskripsi',
        'persyaratan',
        'jenis_magang',
        'open_remote',
        'status',
        'lokasi',
        'perusahaan_id',
    ];

    public function pekerjaan() {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function kontrakMagang()
    {
        return $this->hasMany(KontrakMagang::class);
    }
}
