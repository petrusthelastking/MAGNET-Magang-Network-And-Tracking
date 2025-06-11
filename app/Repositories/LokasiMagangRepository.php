<?php

namespace App\Repositories;

use App\Models\LokasiMagang;

class LokasiMagangRepository
{
    public static function getAllCategorizeLocation()
    {
        return LokasiMagang::all()
            ->groupBy('kategori_lokasi')
            ->map(function ($group) {
                return $group->pluck('lokasi');
            })
            ->toArray();
    }
}
