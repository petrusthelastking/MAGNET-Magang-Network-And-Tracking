<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaOpenRemote extends Model
{
    use HasFactory;

    protected $table = 'kriteria_open_remote';

    protected $fillable = [
        'open_remote',
        'rank',
        'bobot'
    ];
}
