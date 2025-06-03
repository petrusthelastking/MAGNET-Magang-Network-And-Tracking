<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiMagang extends Model
{
    use HasFactory;

    protected $table = 'lokasi_magang';

    protected $fillable = [
        'kategori_lokasi'
    ];

    public function kriteriaLokasiMagang() {
        return $this->hasMany(KriteriaLokasiMagang::class);
    }
}
