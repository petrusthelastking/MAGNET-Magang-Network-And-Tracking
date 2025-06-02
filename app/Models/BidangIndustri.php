<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Perusahaan;

class BidangIndustri extends Model
{
    protected $table = 'bidang_industri';

    protected $fillable = [
        'nama'
    ];

    public function perusahaan() {
        return $this->hasMany(Perusahaan::class);
    }
}
