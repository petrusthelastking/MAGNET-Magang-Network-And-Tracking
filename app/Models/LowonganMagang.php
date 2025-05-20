<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota',
        'keahlian_utama',
        'persyaratan',
        'status'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function pengajuanMagang()
    {
        return $this->hasMany(PengajuanMagang::class, 'lowongan_id');
    }
}
