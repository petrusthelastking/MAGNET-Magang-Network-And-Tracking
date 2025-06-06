<?php

namespace App\Traits;

use App\Models\Mahasiswa;

trait BaseKriteriaModel
{
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
