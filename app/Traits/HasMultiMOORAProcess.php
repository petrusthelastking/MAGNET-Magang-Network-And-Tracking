<?php

namespace App\Traits;

use App\Models\LowonganMagang;
use App\Models\Mahasiswa;

trait HasMultiMOORAProcess
{
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function lowonganMagang()
    {
        return $this->belongsTo(LowonganMagang::class);
    }
}
