<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncodedAlternatives extends Model
{
    use HasFactory;

    protected $model = 'encoded_alternatives';

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_magang_id',
        'pekerjaan',
        'open_remote',
        'jenis_magang',
        'bidang_industri',
        'lokasi_magang'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function lowonganMagang()
    {
        return $this->belongsTo(LowonganMagang::class);
    }
}
