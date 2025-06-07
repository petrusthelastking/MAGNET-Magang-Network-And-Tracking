<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullMultiplicativeForm extends Model
{
    use HasFactory;

    protected $table = 'full_multiplicative_form';

    protected $fillable = [
        'final_rank_recommendation_id',
        'score',
        'rank'
    ];
}
