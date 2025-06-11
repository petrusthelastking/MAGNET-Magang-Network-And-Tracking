<?php

namespace App\Helpers\DecisionMaking;

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
}
