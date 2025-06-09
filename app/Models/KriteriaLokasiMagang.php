<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LokasiMagang;
use App\Traits\BaseKriteriaModel;

class KriteriaLokasiMagang extends Model
{
    use HasFactory, BaseKriteriaModel;

    protected $table = 'kriteria_lokasi_magang';

    protected $fillable = [
        'lokasi_magang_id',
        'mahasiswa_id',
        'rank',
        'bobot'
    ];

    public function lokasi_magang() {
        return $this->belongsTo(LokasiMagang::class);
    }
}
