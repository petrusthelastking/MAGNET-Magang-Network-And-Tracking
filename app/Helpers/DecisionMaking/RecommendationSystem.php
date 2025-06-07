<?php

namespace App\Helpers\DecisionMaking;

use App\Models\LokasiMagang;
use App\Models\LowonganMagang;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;

class RecommendationSystem
{
    /**
     * @var array
     */
    private array $alternatives;

    /**
     * @var array
     */
    private array $lokasi_magang;

    private Mahasiswa $mahasiswa;

    public function __construct(Mahasiswa $mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;

        $this->alternatives = $this->loadAlternatives();
        $this->lokasi_magang = $this->loadLokasiMagang();
    }

    public function runRecommendationSystem()
    {
        $this->dataCategorization();

        $multiMoora = new MultiMOORA($this->mahasiswa, count($this->alternatives));
        $multiMoora->computeMultiMOORA();
    }

    /**
     * Load all alternatives data (lowongan_magang table) from database
     * @return array
     */
    private function loadAlternatives() : array
    {
        return LowonganMagang::with([
            'pekerjaan:id,nama',
            'lokasiMagang:id,lokasi',
            'perusahaan.bidangIndustri:id,nama'
        ])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'pekerjaan' => $item->pekerjaan->nama ?? null,
                'open_remote' => $item->open_remote,
                'jenis_magang' => $item->jenis_magang,
                'bidang_industri' => $item->perusahaan->bidangIndustri->nama ?? null,
                'lokasi_magang' => $item->lokasiMagang->lokasi ?? null,
            ];
        })->toArray();
    }

    /**
     * Load all internship location from table lokasi_magang in database
     * @return array
     */
    private function loadLokasiMagang() : array
    {
        return LokasiMagang::all()
            ->groupBy('kategori_lokasi')
            ->map(function ($group) {
                return $group->pluck('lokasi');
            })
            ->toArray();
    }

    /**
     * Compute data categorization from raw alternatives data
     * @return void
     */
    private function dataCategorization(): void
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
    }
}
