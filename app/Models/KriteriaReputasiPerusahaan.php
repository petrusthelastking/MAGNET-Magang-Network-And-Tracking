<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaReputasiPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'kriteria_reputasi_perusahaan';

    protected $fillable = [
        'reputasi_perusahaan',
        'rank',
        'bobot'
    ];
}
