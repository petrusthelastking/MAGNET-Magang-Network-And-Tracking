<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BerkasPengajuanMagang;
use App\Models\KontakMagang;
use App\Models\PreferensiMahasiswa;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'password',
        'jenis_kelamin',
        'jurusan',
        'program_studi',
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

    public function berkasPengajuanMagang()
    {
        return $this->hasMany(BerkasPengajuanMagang::class);
    }

    public function kontakMagang()
    {
        return $this->hasMany(KontrakMagang::class);
    }

    public function preferensiMahasiswa()
    {
        return $this->hasOne(PreferensiMahasiswa::class);
    }
}
