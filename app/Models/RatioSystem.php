<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatioSystem extends Model
{
    use HasFactory;

    protected $table = 'ratio_system';

    protected $fillable = [
        'final_rank_recommendation_id',
        'score',
        'rank'
    ];
}
