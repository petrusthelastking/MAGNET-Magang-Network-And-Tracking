<?php

namespace App\Helpers\DecisionMaking;

use App\Helpers\DecisionMaking\DataCategorization;
use App\Models\BidangIndustri;
use App\Models\LokasiMagang;
use App\Models\Pekerjaan;

class NumericalEncoding
{
    private static $lokasiMagangList;
    private static $bidangIndustriList;
    private static $pekerjaanList;

    public function __construct()
    {
        self::$lokasiMagangList = LokasiMagang::select('kategori_lokasi', 'lokasi')
            ->get()
            ->groupBy('kategori_lokasi')
            ->map
            ->pluck('lokasi')
            ->toArray();
        self::$bidangIndustriList = BidangIndustri::pluck('nama')->toArray();
        self::$pekerjaanList = Pekerjaan::pluck('nama')->toArray();
    }

    public static function encode(string $column, string $value): int {
        if ($column == 'lokasi_num') {
            return self::encodeLokasiNum($value);
        } else if ($column == 'pekerjaan_num') {
            return self::encodePekerjaanNum($value);
        } else if ($column == 'jenis_magang_num') {
            return self::encodeJenisMagangNum($value);
        } else if ($column == 'open_remote_num') {
            return self::encodeOpenRemoteNum($value);
        } else {
            return 0;
        }
    }

    private static function encodeLokasiNum(string $value): int {
        foreach (self::$lokasiMagangList as $locs) {
            foreach ($locs as $loc) {
                if ($loc == $value) {
                    return 1;
                }
            }
        }
        
        return 0;
    }

    private static function encodePekerjaanNum(string $value): int {
        return 2;
    }

    private static function encodeJenisMagangNum(string $value): int {
        return 3;
    }

    private static function encodeOpenRemoteNum(string $value): int {
        return 4;
    }
}
