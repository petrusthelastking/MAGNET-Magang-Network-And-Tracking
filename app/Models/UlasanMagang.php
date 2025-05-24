<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanMagang extends Model
{
    use HasFactory;

    protected $table = 'ulasan_magang';

    protected $fillable = [
        'kontrak_magang_id',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function kontrakMagang()
    {
        return $this->belongsTo(KontrakMagang::class);
    }
}
