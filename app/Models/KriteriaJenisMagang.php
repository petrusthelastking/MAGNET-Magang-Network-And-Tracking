<?php

namespace App\Models;

use App\Traits\BaseKriteriaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaJenisMagang extends Model
{
    use HasFactory, BaseKriteriaModel;

    protected $table = 'kriteria_jenis_magang';

    protected $fillable = [
        'jenis_magang',
        'mahasiswa_id',
        'rank',
        'bobot'
    ];
}
