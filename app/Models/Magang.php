<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magang';

    protected $fillable = [
        'nama',
        'deskripsi',
        'persyaratan',
        'perusahaan_id',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function kontrakMagang()
    {
        return $this->hasMany(KontrakMagang::class);
    }
}
