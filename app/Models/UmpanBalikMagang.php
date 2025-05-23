<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmpanBalikMagang extends Model
{
    use HasFactory;

    protected $table = 'umpan_balik_magang';

    protected $fillable = [
        'kontak_magang_id',
        'komentar',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kontakMagang()
    {
        return $this->belongsTo(KontrakMagang::class);
    }
}
