<?php

namespace App\Helpers\DecisionMaking;

use App\Models\EncodedAlternatives;
use App\Models\FinalRankRecommendation;
use App\Models\FullMultiplicativeForm;
use App\Models\KriteriaBidangIndustri;
use App\Models\KriteriaJenisMagang;
use App\Models\KriteriaLokasiMagang;
use App\Models\KriteriaOpenRemote;
use App\Models\KriteriaPekerjaan;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa;
use App\Models\RatioSystem;
use App\Models\ReferencePoint;
use App\Models\VectorNormalization;
use Illuminate\Support\Facades\DB;

class MultiMOORA
{
    private int $totalAlternatives;
    private Mahasiswa $mahasiswa;
    private KriteriaPekerjaan $kriteriaPekerjaan;
    private KriteriaOpenRemote $kriteriaOpenRemote;
    private KriteriaBidangIndustri $kriteriaBidangIndustri;
    private KriteriaJenisMagang $kriteriaJenisMagang;
    private KriteriaLokasiMagang $kriteriaLokasiMagang;

    /**
     * @var array<array{
     *  id: int,
     *  pekerjaan: float,
     *  open_remote: float,
     *  jenis_magang: float,
     *  bidang_industri: float,
     *  lokasi_magang: float
     * }>
     */
    private array $vectorNormalizationResult;

    /**
     * @var array<array{
     *  id: int,
     *  score: float,
     *  rank: int
     * }>
     */
    private array $ratioSystemResult;

    /**
     * @var array<array{
     *  id: int,
     *  pekerjaan: float,
     *  open_remote: float,
     *  jenis_magang: float,
     *  bidang_industri: float,
     *  lokasi_magang: float,
     *  max_score: float,
     *  rank: int
     * }>
     */
    private array $referencePointResult;

    /**
     * @var array<array{
     *  id: int,
     *  score: float,
     *  rank: int
     * }>
     */
    private array $fmfResult;

    private string $baseStoragePath;

    public function __construct(Mahasiswa $mahasiswa, int $totalAlternatives)
    {
        $this->mahasiswa = $mahasiswa;
        $this->totalAlternatives = $totalAlternatives;

        $this->kriteriaPekerjaan = $this->mahasiswa->kriteriaPekerjaan;
        $this->kriteriaOpenRemote = $this->mahasiswa->kriteriaOpenRemote;
        $this->kriteriaBidangIndustri = $this->mahasiswa->kriteriaBidangIndustri;
        $this->kriteriaJenisMagang = $this->mahasiswa->kriteriaJenisMagang;
        $this->kriteriaLokasiMagang = $this->mahasiswa->kriteriaLokasiMagang;

        // Set base path for JSON storage
        $this->baseStoragePath = "multimoora/mahasiswa_{$this->mahasiswa->id}";

        // Ensure directory exists
        if (!Storage::exists($this->baseStoragePath)) {
            Storage::makeDirectory($this->baseStoragePath);
        }
    }

    public function computeMultiMOORA(): void
    {
        // Save user preferences
        $this->saveUserPreferences();

        $dataEncodingResult = $this->dataEncoding();
        $this->saveJsonData('01_data_encoding.json', $dataEncodingResult);

        // start multimoora decision making
        $euclideanNormalizationResult = $this->euclideanNormalization($dataEncodingResult);
        $this->saveJsonData('02_euclidean_normalization.json', $euclideanNormalizationResult);

        $this->vectorNormalization($dataEncodingResult, $euclideanNormalizationResult);
        $this->saveJsonData('03_vector_normalization.json', $this->vectorNormalizationResult);

        $this->computeRatioSystem();
        $this->saveJsonData('04_ratio_system.json', $this->ratioSystemResult);

        $this->computeReferencePoint();
        $this->saveJsonData('05_reference_point.json', $this->referencePointResult);

        $this->computeFullMultiplicativeForm();
        $this->saveJsonData('06_fmf_results.json', $this->fmfResult);

        $finalResult = $this->computeFinalRank();
        $this->saveJsonData('07_final_ranking.json', $finalResult);
    }

    /**
     * Save user preferences to JSON
     */
    private function saveUserPreferences(): void
    {
        $preferences = [
            'mahasiswa_id' => $this->mahasiswa->id,
            'mahasiswa_name' => $this->mahasiswa->nama ?? 'Unknown',
            'preferences' => [
                'pekerjaan' => [
                    'value' => $this->kriteriaPekerjaan->pekerjaan->nama,
                    'weight' => $this->kriteriaPekerjaan->bobot
                ],
                'bidang_industri' => [
                    'value' => $this->kriteriaBidangIndustri->bidangIndustri->nama,
                    'weight' => $this->kriteriaBidangIndustri->bobot
                ],
                'jenis_magang' => [
                    'value' => $this->kriteriaJenisMagang->jenis_magang,
                    'weight' => $this->kriteriaJenisMagang->bobot
                ],
                'lokasi_magang' => [
                    'value' => $this->kriteriaLokasiMagang->lokasi_magang->kategori_lokasi,
                    'weight' => $this->kriteriaLokasiMagang->bobot
                ],
                'open_remote' => [
                    'value' => $this->kriteriaOpenRemote->open_remote,
                    'weight' => $this->kriteriaOpenRemote->bobot
                ]
            ],
            'total_alternatives' => $this->totalAlternatives,
            'computation_timestamp' => now()->toISOString()
        ];

        $this->saveJsonData('00_user_preferences.json', $preferences);
    }

    /**
     * Save data to JSON file
     */
    private function saveJsonData(string $filename, array $data): void
    {
        $filePath = $this->baseStoragePath . '/' . $filename;
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        Storage::put($filePath, $jsonData);
    }

    /**
     * Compute data encoding based from to all alternatives data based on user preference
     * @return array<int, array<string, int>>
     */
    private function dataEncoding(): array
    {
        $preference = [
            'pekerjaan' => $this->kriteriaPekerjaan->pekerjaan->nama,
            'bidang_industri' => $this->kriteriaBidangIndustri->bidangIndustri->nama,
            'jenis_magang' => $this->kriteriaJenisMagang->jenis_magang,
            'lokasi_magang' => $this->kriteriaLokasiMagang->lokasi_magang->kategori_lokasi,
            'open_remote' => $this->kriteriaOpenRemote->open_remote
        ];

        $dataCategorized = Storage::read('lowongan_magang/alternatives_categorized.json');
        $dataCategorizedDecoded = json_decode($dataCategorized, true);

        $insertData = array_map(function (array $item) use ($preference): array {
            return [
                'mahasiswa_id' => $this->mahasiswa->id,
                'lowongan_magang_id' => $item['id'],
                'pekerjaan' => $item['pekerjaan'] == $preference['pekerjaan'] ? 2 : 1,
                'open_remote' => $item['open_remote'] == $preference['open_remote'] ? 2 : 1,
                'jenis_magang' => $item['jenis_magang'] == $preference['jenis_magang'] ? 2 : 1,
                'bidang_industri' => $item['bidang_industri'] == $preference['bidang_industri'] ? 2 : 1,
                'lokasi_magang' => $item['lokasi_magang'] == $preference['lokasi_magang'] ? 2 : 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $dataCategorizedDecoded);

        DB::transaction(function () use ($insertData) {
            EncodedAlternatives::insert($insertData);
        });

        return $insertData;
    }

    /**
     * Compute euclidean normalization
     * @return array<string, int[]>
     */
    private function euclideanNormalization(array $encodedAlternatives): array
    {
        $pekerjaanList = collect($encodedAlternatives)->pluck('pekerjaan')->all();
        $bidangIndustriList = collect($encodedAlternatives)->pluck('bidang_industri')->all();
        $jenisMagangList = collect($encodedAlternatives)->pluck('jenis_magang')->all();
        $lokasiMagangList = collect($encodedAlternatives)->pluck('lokasi_magang')->all();
        $openRemoteList = collect($encodedAlternatives)->pluck('open_remote')->all();

        $computeEuclidean = function (array $list) {
            $sumSquares = 0.0;

            foreach ($list as $item) {
                $sumSquares += pow($item, 2);
            }

            return sqrt($sumSquares);
        };

        $listOfCriterias = [
            'pekerjaan' => $pekerjaanList,
            'bidang_industri' => $bidangIndustriList,
            'lokasi_magang' => $lokasiMagangList,
            'open_remote' => $openRemoteList,
            'jenis_magang' => $jenisMagangList
        ];

        $euclideanNormalizationList = [];
        foreach ($listOfCriterias as $criteria => $list) {
            $euclideanNormalizationList[$criteria] = $computeEuclidean($list);
        }

        return $euclideanNormalizationList;
    }

    /**
     * Compute vector normalization for all alternatives data
     * @param array $encodedAlternatives
     * @param array $euclideanNormalization
     * @return void
     */
    private function vectorNormalization(array $encodedAlternatives, array $euclideanNormalization): void
    {
        $pekerjaanList = collect($encodedAlternatives)->pluck('pekerjaan')->all();
        $bidangIndustriList = collect($encodedAlternatives)->pluck('bidang_industri')->all();
        $jenisMagangList = collect($encodedAlternatives)->pluck('jenis_magang')->all();
        $lokasiMagangList = collect($encodedAlternatives)->pluck('lokasi_magang')->all();
        $openRemoteList = collect($encodedAlternatives)->pluck('open_remote')->all();

        $listOfCriterias = [
            'pekerjaan' => $pekerjaanList,
            'bidang_industri' => $bidangIndustriList,
            'lokasi_magang' => $lokasiMagangList,
            'open_remote' => $openRemoteList,
            'jenis_magang' => $jenisMagangList
        ];

        /**
         * Computes the vector normalization for a given criteria using Euclidean normalization.
         *
         * This function takes a specific criteria and a list of values, then normalizes each value
         * by dividing it with the corresponding Euclidean normalization value for that criteria.
         *
         * @param string $criteria The key used to access the corresponding normalization value.
         * @param array $list An array of numeric values to normalize.
         * @return array An array of normalized values.
         */
        $computeVectorNormalization = function (string $criteria, array $list) use ($euclideanNormalization): array {
            $result = [];
            foreach ($list as $item) {
                $result[] = $item / $euclideanNormalization[$criteria];
            }

            return $result;
        };

        $tempResult = [];
        foreach ($listOfCriterias as $criteria => $list) {
            $tempResult[$criteria] = $computeVectorNormalization($criteria, $list);
        }

        $finalVectorNormalization = [];
        for ($i = 0; $i < count($encodedAlternatives); $i++) {
            $finalVectorNormalization[] = [
                'mahasiswa_id' => $this->mahasiswa->id,
                'lowongan_magang_id' => $encodedAlternatives[$i]['lowongan_magang_id'],
                'pekerjaan' => $tempResult['pekerjaan'][$i],
                'open_remote' => $tempResult['open_remote'][$i],
                'jenis_magang' => $tempResult['jenis_magang'][$i],
                'bidang_industri' => $tempResult['bidang_industri'][$i],
                'lokasi_magang' => $tempResult['lokasi_magang'][$i],
            ];
        }

        DB::transaction(function () use ($finalVectorNormalization) {
            VectorNormalization::insert($finalVectorNormalization);
        });

        $this->vectorNormalizationResult = $finalVectorNormalization;
    }

    /**
     * Compute ratio system. The result of this computation will be place in the MultiMOORA object attribute
     * @return void
     */
    private function computeRatioSystem(): void
    {
        $weights = [
            'pekerjaan' => $this->kriteriaPekerjaan->bobot,
            'open_remote' => $this->kriteriaOpenRemote->bobot,
            'bidang_industri' => $this->kriteriaBidangIndustri->bobot,
            'jenis_magang' => $this->kriteriaJenisMagang->bobot,
            'lokasi_magang' => $this->kriteriaLokasiMagang->bobot
        ];

        $ratioSystemResult = array_map(function (array $alt) use ($weights) {
            return [
                'lowongan_magang_id' => $alt['lowongan_magang_id'],
                'score' => array_sum([
                    $alt['pekerjaan'] * $weights['pekerjaan'],
                    $alt['open_remote'] * $weights['open_remote'],
                    $alt['bidang_industri'] * $weights['bidang_industri'],
                    $alt['jenis_magang'] * $weights['jenis_magang'],
                    $alt['lokasi_magang'] * $weights['lokasi_magang']
                ])
            ];
        }, $this->vectorNormalizationResult);

        usort($ratioSystemResult, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $ratioSystemRank = [];
        $rank = 1;
        foreach ($ratioSystemResult as $item) {
            $ratioSystemRank[] = [
                'mahasiswa_id' => $this->mahasiswa->id,
                'lowongan_magang_id' => $item['lowongan_magang_id'],
                'score' => $item['score'],
                'rank' => $rank++,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::transaction(function () use ($ratioSystemRank) {
            RatioSystem::insert($ratioSystemRank);
        });

        $this->ratioSystemResult = $ratioSystemRank;
    }

    /**
     * Compute reference point. The result of this computation will be place in the MultiMOORA object attribute
     * @return void
     */
    private function computeReferencePoint(): void
    {
        $weights = [
            'pekerjaan' => $this->kriteriaPekerjaan->bobot,
            'open_remote' => $this->kriteriaOpenRemote->bobot,
            'bidang_industri' => $this->kriteriaBidangIndustri->bobot,
            'jenis_magang' => $this->kriteriaJenisMagang->bobot,
            'lokasi_magang' => $this->kriteriaLokasiMagang->bobot
        ];

        $referencePointList = [];
        foreach ($this->vectorNormalizationResult as $item) {
            $maxVal = array_reduce($item, function (float $carry, float $curr): float {
                return $curr > $carry ? $curr : $carry;
            }, PHP_FLOAT_MIN);

            $referencePointList[$item['lowongan_magang_id']] = $maxVal;
        }

        $deviationScores = array_map(function (array $alt) use ($referencePointList, $weights) {
            $pekerjaanScore = abs($referencePointList[$alt['lowongan_magang_id']] - $alt['pekerjaan'] * $weights['pekerjaan']);
            $openRemoteScore = abs($referencePointList[$alt['lowongan_magang_id']] - $alt['open_remote'] * $weights['open_remote']);
            $jenisMagangScore = abs($referencePointList[$alt['lowongan_magang_id']] - $alt['jenis_magang'] * $weights['jenis_magang']);
            $bidangIndustriScore = abs($referencePointList[$alt['lowongan_magang_id']] - $alt['bidang_industri'] * $weights['bidang_industri']);
            $lokasiMagangScore = abs($referencePointList[$alt['lowongan_magang_id']] - $alt['lokasi_magang'] * $weights['lokasi_magang']);

            $maxScore = max($pekerjaanScore, $openRemoteScore, $jenisMagangScore, $bidangIndustriScore, $lokasiMagangScore);
            return [
                'lowongan_magang_id' => $alt['lowongan_magang_id'],
                'pekerjaan' => $pekerjaanScore,
                'open_remote' => $openRemoteScore,
                'jenis_magang' => $jenisMagangScore,
                'bidang_industri' => $bidangIndustriScore,
                'lokasi_magang' => $lokasiMagangScore,
                'max_score' => $maxScore
            ];
        }, $this->vectorNormalizationResult);

        // ranking process (descending)
        usort($deviationScores, function ($a, $b) {
            return $b['max_score'] <=> $a['max_score'];
        });

        $referencePointFinalResult = [];
        $rank = 1;
        foreach ($deviationScores as $item) {
            $referencePointFinalResult[] = [
                'mahasiswa_id' => $this->mahasiswa->id,
                'lowongan_magang_id' => $item['lowongan_magang_id'],
                'pekerjaan' => $item['pekerjaan'],
                'open_remote' => $item['open_remote'],
                'jenis_magang' => $item['jenis_magang'],
                'bidang_industri' => $item['bidang_industri'],
                'lokasi_magang' => $item['lokasi_magang'],
                'max_score' => $item['max_score'],
                'rank' => $rank++,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::transaction(function () use ($referencePointFinalResult) {
            ReferencePoint::insert($referencePointFinalResult);
        });

        $this->referencePointResult = $referencePointFinalResult;
    }

    /**
     * Compute Full Multiplicative Form (FMF). The result of this computation will be place in the MultiMOORA object attribute
     * @return void
     */
    private function computeFullMultiplicativeForm(): void
    {
        $weights = [
            'pekerjaan' => $this->kriteriaPekerjaan->bobot,
            'open_remote' => $this->kriteriaOpenRemote->bobot,
            'bidang_industri' => $this->kriteriaBidangIndustri->bobot,
            'jenis_magang' => $this->kriteriaJenisMagang->bobot,
            'lokasi_magang' => $this->kriteriaLokasiMagang->bobot
        ];

        $fmfScores = array_map(function (array $alt) use ($weights): array {
            $scores = [
                pow($alt['pekerjaan'], $weights['pekerjaan']),
                pow($alt['open_remote'], $weights['open_remote']),
                pow($alt['bidang_industri'], $weights['bidang_industri']),
                pow($alt['jenis_magang'], $weights['jenis_magang']),
                pow($alt['lokasi_magang'], $weights['lokasi_magang'])
            ];

            return [
                'lowongan_magang_id' => $alt['lowongan_magang_id'],
                'score' => array_reduce($scores, fn($carry, $item) => $carry * $item, 1),
            ];
        }, $this->vectorNormalizationResult);

        // ranking process (descending)
        usort($fmfScores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $fmfFinalRanks = [];
        $rank = 1;
        foreach ($fmfScores as $item) {
            $fmfFinalRanks[] = [
                'mahasiswa_id' => $this->mahasiswa->id,
                'lowongan_magang_id' => $item['lowongan_magang_id'],
                'score' => $item['score'],
                'rank' => $rank++,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::transaction(function () use ($fmfFinalRanks) {
            FullMultiplicativeForm::insert($fmfFinalRanks);
        });

        $this->fmfResult = $fmfFinalRanks;
    }

    /**
     * Compute final rank of alternatives with MultiMOORA method
     * @return array
     */
    private function computeFinalRank(): array
    {
        $ratioSystemRanks = array_column($this->ratioSystemResult, 'rank', 'lowongan_magang_id');
        $referencePointRanks = array_column($this->referencePointResult, 'rank', 'lowongan_magang_id');
        $fmfRanks = array_column($this->fmfResult, 'rank', 'lowongan_magang_id');

        // collect all IDs
        $allIDs = array_unique(
            array_merge(
                array_keys($ratioSystemRanks),
                array_keys($referencePointRanks),
                array_keys($fmfRanks)
            )
        );

        // combine all array into a single array based on ID
        $combinedArray = [];
        foreach ($allIDs as $id) {
            $avgRank = array_sum([$ratioSystemRanks[$id], $referencePointRanks[$id], $fmfRanks[$id]]) / 3;
            $combinedArray[] = [
                'lowongan_magang_id' => $id,
                'ratio_system_rank' => $ratioSystemRanks[$id] ?? null,
                'reference_point_rank' => $referencePointRanks[$id] ?? null,
                'fmf_rank' => $fmfRanks[$id] ?? null,
                'avg_rank' => $avgRank
            ];
        }

        // ranking process (ascending)
        usort($combinedArray, function ($a, $b) {
            return $a['avg_rank'] <=> $b['avg_rank'];
        });

        $ratioSystemIDs = RatioSystem::select('id')
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->orderBy('updated_at', 'desc')
            ->limit($this->totalAlternatives)
            ->get()
            ->toArray();

        $referencePointIDs = ReferencePoint::select('id')
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->orderBy('updated_at', 'desc')
            ->limit($this->totalAlternatives)
            ->get()
            ->toArray();

        $fmfIDs = FullMultiplicativeForm::select('id')
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->orderBy('updated_at', 'desc')
            ->limit($this->totalAlternatives)
            ->get()
            ->toArray();

        $finalRanks = [];
        $rank = 1;
        foreach ($combinedArray as $key => $item) {
            $finalRanks[] = [
                'mahasiswa_id' => $this->mahasiswa->id,
                'lowongan_magang_id' => $item['lowongan_magang_id'],
                'ratio_system_id' => $ratioSystemIDs[$key]['id'],
                'reference_point_id' => $referencePointIDs[$key]['id'],
                'fmf_id' => $fmfIDs[$key]['id'],
                'avg_rank' => $item['avg_rank'],
                'rank' => $rank++,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::transaction(function () use ($finalRanks) {
            FinalRankRecommendation::insert($finalRanks);
        });

        return $finalRanks;
    }
}
