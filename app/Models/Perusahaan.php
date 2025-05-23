<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'nama',
        'bidang_industri',
        'lokasi',
        'kategori',
        'rating',
    ];

    protected $casts = [
        'bidang_industri' => 'string',
        'kategori' => 'string',
        'rating' => 'float',
    ];

    public function magang()
    {
        return $this->hasMany(Magang::class);
    }
}
