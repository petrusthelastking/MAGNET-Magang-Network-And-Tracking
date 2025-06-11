<?php

namespace App\Repositories;

use App\Models\LowonganMagang;

class LowonganMagangRepository
{
    public static function getAllAlternatives()
    {
        return LowonganMagang::with([
            'pekerjaan:id,nama',
            'lokasi_magang:id,lokasi',
            'perusahaan.bidangIndustri:id,nama'
        ])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'pekerjaan' => $item->pekerjaan->nama ?? null,
                'open_remote' => $item->open_remote,
                'jenis_magang' => $item->jenis_magang,
                'bidang_industri' => $item->perusahaan->bidangIndustri->nama ?? null,
                'lokasi_magang' => $item->lokasi_magang->lokasi ?? null,
            ];
        })->toArray();
    }
}
