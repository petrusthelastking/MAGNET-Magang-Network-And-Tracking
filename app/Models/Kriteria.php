<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'nama_kriteria',
        'nilai',
        'nilai_numerik',
        'rank',
    ];

    protected $casts = [
        'nilai_numerik' => 'float',
        'rank' => 'integer',
    ];

    public function preferensiBidangPekerjaan()
    {
        return $this->hasMany(PreferensiMahasiswa::class, 'bidang_pekerjaan');
    }

    public function preferensiLokasi()
    {
        return $this->hasMany(PreferensiMahasiswa::class, 'lokasi');
    }

    public function preferensiReputasi()
    {
        return $this->hasMany(PreferensiMahasiswa::class, 'reputasi');
    }

    public function preferensiUangSaku()
    {
        return $this->hasMany(PreferensiMahasiswa::class, 'uang_saku');
    }

    public function preferensiOpenRemote()
    {
        return $this->hasMany(PreferensiMahasiswa::class, 'open_remote');
    }
}
