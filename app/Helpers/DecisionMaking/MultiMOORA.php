<?php

namespace App\Helpers\DecisionMaking;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\LokasiMagang;
use App\Models\PreferensiMahasiswa;

class MultiMOORA
{
    private array $criterias;
    private array $alternatives;
    private PreferensiMahasiswa $preferensiMahasiswa;

    public function __construct(array $criterias, array $alternatives, PreferensiMahasiswa $preferensiMahasiswa)
    {
        $this->criterias = $criterias;
        $this->alternatives = $alternatives;
        $this->preferensiMahasiswa = $preferensiMahasiswa;
    }

    private function dataCategorization(): void {
        // convert raw data to json file
        $jsonDataRaw = json_encode($this->alternatives, JSON_PRETTY_PRINT);
        Storage::put('raw_lowongan_magang.json', $jsonDataRaw);

        // data categorization
        $lokasiDataFromDB = LokasiMagang::all()
            ->groupBy('kategori_lokasi')
            ->map(function ($group) {
                return $group->pluck('lokasi');
            })
            ->toArray();
        $lokasiJson = json_encode($lokasiDataFromDB, JSON_PRETTY_PRINT);
        Storage::put('lokasi.json', $lokasiJson);

        // encoding
        $locationMap = [];
        foreach ($lokasiDataFromDB as $category => $locations) {
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

        unset($internship);

        $jsonDataCategorized = json_encode($this->alternatives, JSON_PRETTY_PRINT);
        Storage::put('lowongan_categorized.json', $jsonDataCategorized);
    }

    private function dataEncoding(): void {
        $pekerjaan = $this->preferensiMahasiswa->kriteriaPekerjaan->pekerjaan->nama;
        $bidang_industri = $this->preferensiMahasiswa->kriteriaBidangIndustri->bidangIndustri->nama;
        $jenis_magang = $this->preferensiMahasiswa->kriteriaJenisMagang->jenis_magang;
        $lokasi_magang = $this->preferensiMahasiswa->kriteriaLokasiMagang->lokasiMagang->kategori_lokasi;
        $open_remote = $this->preferensiMahasiswa->kriteriaOpenRemote->open_remote;

        $dataCategorized = Storage::read('lowongan_categorized.json');
        $dataCategorizedDecoded = json_decode($dataCategorized, true);

        foreach ($dataCategorizedDecoded as &$item) {
            $item['pekerjaan'] = $item['pekerjaan'] == $pekerjaan ? 2 : 1;
            $item['bidang_industri'] = $item['bidang_industri'] == $bidang_industri ? 2 : 1;
            $item['jenis_magang'] = $item['jenis_magang'] == $jenis_magang ? 2 : 1;
            $item['lokasi_magang'] = $item['lokasi_magang'] == $lokasi_magang ? 2 : 1;
            $item['open_remote'] = $item['open_remote'] == $open_remote ? 2 : 1;
        }

        // encoded alternatives for current user
        $dataCategorizedEncoded = json_encode($dataCategorizedDecoded, JSON_PRETTY_PRINT);
        Storage::put('preference_internship.json', $dataCategorizedEncoded);
    }

    public function computeMultiMOORA()
    {
        $this->dataCategorization();
        $this->dataEncoding();
    }

    private function euclideanNormalization() {}

    private function vectorNormalization() {}

    private function computeRatioSystem() {}

    private function computeReferencePoint() {}

    private function computeFullMultiplicativeForm() {}

    private function computeFinalRank() {}
}
