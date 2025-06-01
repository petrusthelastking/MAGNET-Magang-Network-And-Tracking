<?php

namespace App\Models;

use App\Models\BerkasPengajuanMagang;
use App\Models\PreferensiMahasiswa;
use App\Models\KontrakMagang;
use App\Models\UserBase;

class Mahasiswa extends UserBase
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'password',
        'jenis_kelamin',
        'jurusan',
        'program_studi',
        'angkatan',
        'tanggal_lahir',
        'status_magang',
        'alamat',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'status_magang' => 'string',
    ];

    public function getRoleName(): string
    {
        return 'mahasiswa';
    }

    public function berkasPengajuanMagang()
    {
        return $this->hasMany(BerkasPengajuanMagang::class);
    }

    public function kontrakMagang()
    {
        return $this->hasMany(KontrakMagang::class);
    }

    public function preferensiMahasiswa()
    {
        return $this->hasOne(PreferensiMahasiswa::class);
    }
}
