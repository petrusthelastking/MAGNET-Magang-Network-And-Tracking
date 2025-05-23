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
        'bidang_pekerjaan',
        'lokasi',
        'reputasi',
        'uang_saku',
        'open_remote',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function kriteriaBidangPekerjaan()
    {
        return $this->belongsTo(Kriteria::class, 'bidang_pekerjaan');
    }

    public function kriteriaLokasi()
    {
        return $this->belongsTo(Kriteria::class, 'lokasi');
    }

    public function kriteriaReputasi()
    {
        return $this->belongsTo(Kriteria::class, 'reputasi');
    }

    public function kriteriaUangSaku()
    {
        return $this->belongsTo(Kriteria::class, 'uang_saku');
    }

    public function kriteriaOpenRemote()
    {
        return $this->belongsTo(Kriteria::class, 'open_remote');
    }
}
