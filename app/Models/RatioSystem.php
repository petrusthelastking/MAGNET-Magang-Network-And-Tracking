<?php

namespace App\Models;

use App\Traits\HasMultiMOORAProcess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatioSystem extends Model
{
    use HasFactory, HasMultiMOORAProcess;

    protected $table = 'ratio_system';

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_magang_id',
        'score',
        'rank'
    ];
}
