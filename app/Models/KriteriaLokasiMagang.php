<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LokasiMagang;

class KriteriaLokasiMagang extends Model
{
    use HasFactory;

    protected $table = 'kriteria_lokasi_magang';

    protected $fillable = [
        'lokasi_magang_id',
        'rank',
        'bobot'
    ];

    public function lokasiMagang() {
        return $this->belongsTo(LokasiMagang::class);
    }
}
