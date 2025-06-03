<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pekerjaan;

class KriteriaPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'kriteria_pekerjaan';

    protected $fillable = [
        'pekerjaan_id',
        'rank',
        'bobot'
    ];

    public function pekerjaan() {
        return $this->belongsTo(Pekerjaan::class);
    }
}
