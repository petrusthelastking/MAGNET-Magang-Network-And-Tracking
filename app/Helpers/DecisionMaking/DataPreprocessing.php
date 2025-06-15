<?php

namespace App\Helpers\DecisionMaking;

use App\Models\EncodedAlternatives;
use App\Models\LokasiMagang;
use App\Models\LowonganMagang;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataPreprocessing
{
    /**
     * Compute data categorization from raw alternatives data
     * @return void
     */
    public static function dataCategorization(LowonganMagang $lowonganMagang): void
    {
        $alternative = [
            'id' => $lowonganMagang->id,
            'pekerjaan' => $lowonganMagang->pekerjaan->nama,
            'open_remote' => $lowonganMagang->open_remote,
            'jenis_magang' => $lowonganMagang->jenis_magang,
            'bidang_industri' => $lowonganMagang->perusahaan->bidangIndustri->nama,
            'lokasi_magang' => $lowonganMagang->lokasi_magang->lokasi
        ];

        $lokasi_magang_list = LokasiMagang::pluck('kategori_lokasi', 'lokasi')
            ->toArray();

        $lokasi = $alternative['lokasi_magang'];
        $alternative['lokasi_magang'] = $lokasi_magang_list[$lokasi];

        $file_path = 'lowongan_magang/alternatives_categorized.json';
        $contentFile = Storage::get($file_path);
        $fileDecoded = json_decode($contentFile, true);

        $fileDecoded[] = $alternative;
        Storage::put($file_path, json_encode($fileDecoded, JSON_PRETTY_PRINT));
    }



    /**
     * Compute data encoding based from to all alternatives data based on user preference
     * @return array<int, array<string, int>>
     */
    public static function dataEncoding(Mahasiswa $mahasiswa): void
    {
        $preference = [
            'pekerjaan' => $mahasiswa->kriteriaPekerjaan->pekerjaan->nama,
            'bidang_industri' => $mahasiswa->kriteriaBidangIndustri->bidangIndustri->nama,
            'jenis_magang' => $mahasiswa->kriteriaJenisMagang->jenis_magang,
            'lokasi_magang' => $mahasiswa->kriteriaLokasiMagang->lokasi_magang->kategori_lokasi,
            'open_remote' => $mahasiswa->kriteriaOpenRemote->open_remote
        ];

        $dataCategorized = Storage::read('lowongan_magang/alternatives_categorized.json');
        $dataCategorizedDecoded = json_decode($dataCategorized, true);

        $now = now();

        $result = array_map(
            fn(array $item): array => [
                'mahasiswa_id' => $mahasiswa->id,
                'lowongan_magang_id' => $item['id'],
                'pekerjaan' => $item['pekerjaan'] == $preference['pekerjaan'] ? 2 : 1,
                'open_remote' => $item['open_remote'] == $preference['open_remote'] ? 2 : 1,
                'jenis_magang' => $item['jenis_magang'] == $preference['jenis_magang'] ? 2 : 1,
                'bidang_industri' => $item['bidang_industri'] == $preference['bidang_industri'] ? 2 : 1,
                'lokasi_magang' => $item['lokasi_magang'] == $preference['lokasi_magang'] ? 2 : 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            $dataCategorizedDecoded
        );

        DB::transaction(function () use ($result) {
            EncodedAlternatives::insert($result);
        });
    }
}
