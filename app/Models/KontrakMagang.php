<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakMagang extends Model
{
    use HasFactory;

    protected $table = 'kontrak_magang';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'lowongan_magang_id',
        'waktu_awal',
        'waktu_akhir',
    ];

    protected $casts = [
        'waktu_awal' => 'datetime',
        'waktu_akhir' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(DosenPembimbing::class);
    }

    public function lowongan_magang()
    {
        return $this->belongsTo(LowonganMagang::class);
    }

    public function logMagang()
    {
        return $this->hasMany(LogMagang::class);
    }

    public function ulasanMagang()
    {
        return $this->hasOne(UlasanMagang::class);
    }

    public function umpanBalikMagang()
    {
        return $this->hasMany(UmpanBalikMagang::class);
    }
}
