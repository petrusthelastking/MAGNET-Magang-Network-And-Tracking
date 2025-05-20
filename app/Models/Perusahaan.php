<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'kota',
        'provinsi',
        'bidang_industri',
        'no_telp',
        'email',
        'deskripsi',
        'tahun_berdiri',
        'logo_path'
    ];

    public function lowonganMagang()
    {
        return $this->hasMany(LowonganMagang::class);
    }
}
