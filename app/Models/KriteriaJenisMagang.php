<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaJenisMagang extends Model
{
    use HasFactory;

    protected $table = 'kriteria_jenis_magang';

    protected $fillable = [
        'jenis_magang',
        'rank',
        'bobot'
    ];
}
