<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiMagang extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id', 'keahlian', 'pekerjaan_impian', 'lokasi_magang', 'bidang_inustri'];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaProfiles::class, 'mahasiswa_id');
    }
}
