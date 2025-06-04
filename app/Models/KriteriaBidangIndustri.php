<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaBidangIndustri extends Model
{
    use HasFactory;

    protected $table = 'kriteria_bidang_industri';

    protected $fillable = [
        'bidang_industri_id',
        'rank',
        'bobot'
    ];

    public function bidangIndustri() {
        return $this->belongsTo(BidangIndustri::class);
    }
}
