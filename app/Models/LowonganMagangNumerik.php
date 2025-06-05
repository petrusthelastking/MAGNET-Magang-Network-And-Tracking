<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganMagangNumerik extends Model
{
    use HasFactory;

    protected $table = 'lowongan_magang_numerik';

    protected $fillable = [
        'lowongan_magang_id',
        'lokasi_num',
        'pekerjaan_num',
        'jenis_magang_num',
        'open_remote_num',
        'bidang_industri_num'
    ];

    public function lowonganMagang() {
        return $this->belongsTo(LowonganMagang::class);
    }
}
