<?php

namespace App\Models;

use App\Traits\BaseKriteriaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaBidangIndustri extends Model
{
    use HasFactory, BaseKriteriaModel;

    protected $table = 'kriteria_bidang_industri';

    protected $fillable = [
        'bidang_industri_id',
        'mahasiswa_id',
        'rank',
        'bobot'
    ];

    public function bidangIndustri() {
        return $this->belongsTo(BidangIndustri::class);
    }
}
