<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pekerjaan;
use App\Traits\BaseKriteriaModel;

class KriteriaPekerjaan extends Model
{
    use HasFactory, BaseKriteriaModel;

    protected $table = 'kriteria_pekerjaan';

    protected $fillable = [
        'pekerjaan_id',
        'mahasiswa_id',
        'rank',
        'bobot'
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }
}
