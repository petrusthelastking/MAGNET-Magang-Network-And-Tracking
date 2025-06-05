<?php

namespace App\Helpers\DecisionMaking;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MultiMOORA
{
    private array $criterias;
    private array $alternatives;

    public function __construct(array $criterias, array $alternatives)
    {
        $this->criterias = $criterias;
        $this->alternatives = $alternatives;
    }

    public function computeMultiMOORA()
    {
        // data categorization
        $lokasiList = array_map(function ($item) {
            return $item['lokasi_magang_id'] ?? null;
        }, $this->alternatives);

        ob_start();
        var_dump($lokasiList);
        $dump = ob_get_clean();

        // Save to storage/app/debug.txt
        Storage::disk('local')->put('debug/debug.txt', $dump);

        $dataahah = DataCategorization::categorizeData('lokasi_magang', $lokasiList);

        ob_start();
        var_dump($dataahah);
        $dump = ob_get_clean();

        // Save to storage/app/debug.txt
        Storage::disk('local')->put('debug/debug_99.txt', $dump);
    }

    private function euclideanNormalization() {}

    private function vectorNormalization() {}

    private function computeRatioSystem() {}

    private function computeReferencePoint() {}

    private function computeFullMultiplicativeForm() {}

    private function computeFinalRank() {}
}
