<?php

namespace App\Helpers\DecisionMaking;

use App\Models\EncodedAlternatives;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataPreprocessing
{
    private array $lokasi_magang;

    private array $alternatives;

    public function __construct(array $alternatives, array $lokasi_magang)
    {
        $this->alternatives = $alternatives;
        $this->lokasi_magang = $lokasi_magang;

        $this->dataCategorization();
    }

    /**
     * Compute data categorization from raw alternatives data
     * @return void
     */
    public function dataCategorization(): array
    {
        $locationMap = [];
        foreach ($this->lokasi_magang as $category => $locations) {
            foreach ($locations as $location) {
                $locationMap[$location] = $category;
            }
        }

        foreach ($this->alternatives as &$alt) {
            $lokasi = $alt['lokasi_magang'];

            if (isset($locationMap[$lokasi])) {
                $alt['lokasi_magang'] = $locationMap[$lokasi];
            }
        }

        $jsonDataCategorized = json_encode($this->alternatives, JSON_PRETTY_PRINT);

        $file_path = 'lowongan_magang/alternatives_categorized.json';
        Storage::put($file_path, $jsonDataCategorized);

        return $this->alternatives;
    }

    /**
     * Compute data encoding based from to all alternatives data based on user preference
     * @return array<int, array<string, int>>
     */
    public static function dataEncoding(Mahasiswa $mahasiswa): array
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

        $result = array_map(function (array $item) use ($preference, $mahasiswa, $now): array {
            return [
                'mahasiswa_id' => $mahasiswa->id,
                'lowongan_magang_id' => $item['id'],
                'pekerjaan' => $item['pekerjaan'] == $preference['pekerjaan'] ? 2 : 1,
                'open_remote' => $item['open_remote'] == $preference['open_remote'] ? 2 : 1,
                'jenis_magang' => $item['jenis_magang'] == $preference['jenis_magang'] ? 2 : 1,
                'bidang_industri' => $item['bidang_industri'] == $preference['bidang_industri'] ? 2 : 1,
                'lokasi_magang' => $item['lokasi_magang'] == $preference['lokasi_magang'] ? 2 : 1,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }, $dataCategorizedDecoded);

        DB::transaction(function () use ($result) {
            EncodedAlternatives::insert($result);
        });

        return $result;
    }
}
