<?php

namespace App\Helpers\DecisionMaking;

use App\Models\KriteriaBidangIndustri;
use App\Models\KriteriaJenisMagang;
use App\Models\KriteriaLokasiMagang;
use App\Models\KriteriaOpenRemote;
use App\Models\KriteriaPekerjaan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\LokasiMagang;
use App\Models\PreferensiMahasiswa;

class MultiMOORA
{
    private array $criterias;
    private array $alternatives;
    private PreferensiMahasiswa $preferensiMahasiswa;
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

    /**
     * @var array<array{
     *  id: int,
     *  avg_rank: float,
     *  rank: int
     * }>
     */
    private array $finalRanks;


    public function __construct(array $criterias, array $alternatives, PreferensiMahasiswa $preferensiMahasiswa)
    {
        $this->criterias = $criterias;
        $this->alternatives = $alternatives;
        $this->preferensiMahasiswa = $preferensiMahasiswa;

        $this->kriteriaPekerjaan = $this->preferensiMahasiswa->kriteriaPekerjaan;
        $this->kriteriaOpenRemote = $this->preferensiMahasiswa->kriteriaOpenRemote;
        $this->kriteriaBidangIndustri = $this->preferensiMahasiswa->kriteriaBidangIndustri;
        $this->kriteriaJenisMagang = $this->preferensiMahasiswa->kriteriaJenisMagang;
        $this->kriteriaLokasiMagang = $this->preferensiMahasiswa->kriteriaLokasiMagang;
    }

    public function computeMultiMOORA(): void
    {
        $this->dataCategorization();
        $dataEncodingResult = $this->dataEncoding();

        // start multimoora decision making
        $euclideanNormalizationResult = $this->euclideanNormalization($dataEncodingResult);
        $this->vectorNormalization($euclideanNormalizationResult);
        $this->computeRatioSystem();
        $this->computeReferencePoint();
        $this->computeFullMultiplicativeForm();
        $this->computeFinalRank();
    }

    /**
     * Compute data categorization from raw alternatives data
     * @return void
     */
    private function dataCategorization(): void
    {
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

    /**
     * Compute data encoding based from to all alternatives data based on user preference
     * @return array<int, array<string, int>>
     */
    private function dataEncoding(): array
    {
        $pekerjaan = $this->kriteriaPekerjaan->pekerjaan->nama;
        $bidang_industri = $this->kriteriaBidangIndustri->bidangIndustri->nama;
        $jenis_magang = $this->kriteriaJenisMagang->jenis_magang;
        $lokasi_magang = $this->kriteriaLokasiMagang->lokasiMagang->kategori_lokasi;
        $open_remote = $this->kriteriaOpenRemote->open_remote;

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
        Storage::put('preference_internship_mahasiswa_1.json', $dataCategorizedEncoded);

        return $dataCategorizedDecoded;
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

        $euclideanNormalizationEncoded = json_encode($euclideanNormalizationList, JSON_PRETTY_PRINT);
        Storage::put('euclidean_normalization_mahasiswa_1.json', $euclideanNormalizationEncoded);

        return $euclideanNormalizationList;
    }

    /**
     * Compute vector normalization for all alternatives data
     * @param array $euclideanNormalization
     * @return void
     */
    private function vectorNormalization(array $euclideanNormalization): void
    {
        $preferenceInternship = Storage::read('preference_internship_mahasiswa_1.json');
        $preferenceInternship = json_decode($preferenceInternship, true);
        $euclideanNormalization = Storage::read('euclidean_normalization_mahasiswa_1.json');
        $euclideanNormalizationD = json_decode($euclideanNormalization, true);

        $pekerjaanList = collect($preferenceInternship)->pluck('pekerjaan')->all();
        $bidangIndustriList = collect($preferenceInternship)->pluck('bidang_industri')->all();
        $jenisMagangList = collect($preferenceInternship)->pluck('jenis_magang')->all();
        $lokasiMagangList = collect($preferenceInternship)->pluck('lokasi_magang')->all();
        $openRemoteList = collect($preferenceInternship)->pluck('open_remote')->all();

        $listOfCriterias = [
            'pekerjaan' => $pekerjaanList,
            'bidang_industri' => $bidangIndustriList,
            'lokasi_magang' => $lokasiMagangList,
            'open_remote' => $openRemoteList,
            'jenis_magang' => $jenisMagangList
        ];

        $computeVectorNormalization = function (string $criteria, array $list) use ($euclideanNormalizationD): array {
            $result = [];
            foreach ($list as $item) {
                $result[] = $item / $euclideanNormalizationD[$criteria];
            }

            return $result;
        };

        $tempResult = [];
        foreach ($listOfCriterias as $criteria => $list) {
            $tempResult[$criteria] = $computeVectorNormalization($criteria, $list);
        }

        $finalResult = [];
        for ($i = 0; $i < count($preferenceInternship); $i++) {
            $finalResult[] = [
                'id' => $preferenceInternship[$i]['id'],
                'pekerjaan' => $tempResult['pekerjaan'][$i],
                'open_remote' => $tempResult['open_remote'][$i],
                'jenis_magang' => $tempResult['jenis_magang'][$i],
                'bidang_industri' => $tempResult['bidang_industri'][$i],
                'lokasi_magang' => $tempResult['lokasi_magang'][$i]
            ];
        }

        $finalResultEncoded = json_encode($finalResult, JSON_PRETTY_PRINT);
        Storage::put('vector_normalization_mahasiswa_1.json', $finalResultEncoded);

        $this->vectorNormalizationResult = $finalResult;
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
                'id' => $alt['id'],
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
                'id' => $item['id'],
                'score' => $item['score'],
                'rank' => $rank++
            ];
        }

        $this->ratioSystemResult = $ratioSystemRank;

        $ratioSystemResultJSON = json_encode($ratioSystemRank, JSON_PRETTY_PRINT);
        Storage::put('ratio_system_mahasiswa_1.json', $ratioSystemResultJSON);
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

            $referencePointList[$item['id']] = $maxVal;
        }

        $deviationScores = array_map(function (array $alt) use ($referencePointList, $weights) {
            $pekerjaanScore = abs($referencePointList[$alt['id']] - $alt['pekerjaan'] * $weights['pekerjaan']);
            $openRemoteScore = abs($referencePointList[$alt['id']] - $alt['open_remote'] * $weights['open_remote']);
            $jenisMagangScore = abs($referencePointList[$alt['id']] - $alt['jenis_magang'] * $weights['jenis_magang']);
            $bidangIndustriScore = abs($referencePointList[$alt['id']] - $alt['bidang_industri'] * $weights['bidang_industri']);
            $lokasiMagangScore = abs($referencePointList[$alt['id']] - $alt['lokasi_magang'] * $weights['lokasi_magang']);

            $maxScore = max($pekerjaanScore, $openRemoteScore, $jenisMagangScore, $bidangIndustriScore, $lokasiMagangScore);
            return [
                'id' => $alt['id'],
                'pekerjaan' => $pekerjaanScore,
                'open_remote' => $openRemoteScore,
                'jenis_magang' => $jenisMagangScore,
                'bidang_industri' => $bidangIndustriScore,
                'lokasi_magang' => $lokasiMagangScore,
                'max_score' => $maxScore
            ];
        }, $this->vectorNormalizationResult);

        $referencePointResultJSON = json_encode($deviationScores, JSON_PRETTY_PRINT);
        Storage::put('deviation_scores_mahasiswa_1.json', $referencePointResultJSON);


        // ranking process (descending)
        usort($deviationScores, function ($a, $b) {
            return $b['max_score'] <=> $a['max_score'];
        });

        $referencePointFinalResult = [];
        $rank = 1;
        foreach ($deviationScores as $item) {
            $referencePointFinalResult[] = [
                'id' => $item['id'],
                'pekerjaan' => $item['pekerjaan'],
                'open_remote' => $item['open_remote'],
                'jenis_magang' => $item['jenis_magang'],
                'bidang_industri' => $item['bidang_industri'],
                'lokasi_magang' => $item['lokasi_magang'],
                'max_score' => $item['max_score'],
                'rank' => $rank++
            ];
        }

        $this->referencePointResult = $referencePointFinalResult;

        $referenceFinalPointResultJSON = json_encode($referencePointFinalResult, JSON_PRETTY_PRINT);
        Storage::put('reference_point_final_mahasiswa_1.json', $referenceFinalPointResultJSON);
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
                'id' => $alt['id'],
                'score' => array_reduce($scores, function (float $carry, float $item): float {
                    return $carry * $item;
                }, 1),
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
                'id' => $item['id'],
                'score' => $item['score'],
                'rank' => $rank++
            ];
        }

        $this->fmfResult = $fmfFinalRanks;

        $fmfFinalRanksJSON = json_encode($fmfFinalRanks, JSON_PRETTY_PRINT);
        Storage::put('fmf_ranks_mahasiswa_1.json', $fmfFinalRanksJSON);
    }

    /**
     * Compute final rank of alternatives with MultiMOORA method
     * @return void
     */
    private function computeFinalRank()
    {
        $ratioSystemRanks = array_column($this->ratioSystemResult, 'rank', 'id');
        $referencePointRanks = array_column($this->referencePointResult, 'rank', 'id');
        $fmfRanks = array_column($this->fmfResult, 'rank', 'id');

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
            $combinedArray[$id] = [
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

        $finalRanks = [];
        $rank = 1;
        foreach ($combinedArray as $key => $val) {
            $finalRanks[$key] = [
                'ratio_system_rank' => $val['ratio_system_rank'],
                'reference_point_rank' => $val['reference_point_rank'],
                'fmf_rank' => $val['fmf_rank'],
                'avg_rank' => $val['avg_rank'],
                'final_rank' => $rank++
            ];
        }

        $this->finalRanks = $finalRanks;

        $finalRanksJSON = json_encode($finalRanks, JSON_PRETTY_PRINT);
        Storage::put('final_ranks_mahasiswa_1.json', $finalRanksJSON);
    }
}
