<?php

namespace App\Helpers\DecisionMaking;

use App\Models\LokasiMagang;
use Illuminate\Support\Facades\Log;

class DataCategorization
{
    public static function categorizeData(string $column, array $dataSource): array {
        if ($column == 'lokasi_magang') {
            $lokasiMagangList = LokasiMagang::all()
                ->groupBy('kategori_lokasi')
                ->map(function ($group) {
                    return $group->pluck('lokasi');
                })
                ->toArray();

            $newValues = [];
            foreach ($dataSource as $value) {
                foreach ($lokasiMagangList as $lokasiKategori => $lokasiList) {
                    if (in_array($value, $lokasiList)) {
                        $newValues[] = $lokasiKategori;
                    }
                }
            }

            return $newValues;
        } else {
            return [];
        }
    }
}
