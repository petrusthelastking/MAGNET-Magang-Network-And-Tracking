<?php

namespace App\Models;

use App\Traits\BaseKriteriaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaOpenRemote extends Model
{
    use HasFactory, BaseKriteriaModel;

    protected $table = 'kriteria_open_remote';

    protected $fillable = [
        'open_remote',
        'mahasiswa_id',
        'rank',
        'bobot'
    ];
}
