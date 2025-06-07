<?php

namespace App\Models;

use App\Traits\HasMultiMOORAProcess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VectorNormalization extends Model
{
    use HasFactory, HasMultiMOORAProcess;

    protected $table = 'vector_normalization';

    protected $fillable = [
        'final_rank_recommendation_id',
        'pekerjaan',
        'open_remote',
        'jenis_magang',
        'bidang_industri',
        'lokasi_magang'
    ];
}
