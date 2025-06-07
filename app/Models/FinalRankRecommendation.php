<?php

namespace App\Models;

use App\Traits\HasMultiMOORAProcess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalRankRecommendation extends Model
{
    use HasFactory, HasMultiMOORAProcess;

    protected $table = 'final_rank_recommendation';

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_magang_id',
        'avg_rank',
        'rank'
    ];
}
