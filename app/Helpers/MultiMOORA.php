<?php

namespace App\Helpers;

use App\Helpers\ROC;

class MultiMOORA
{
    /**
     * Menghitung ranking MultiMOORA untuk alternatif magang
     *
     * @param array $alternatif Array alternatif dengan nilai kriteria
     * @param array $preferensiKriteria Preferensi mahasiswa dengan ranking kriteria
     * @param array $tipeKriteria Array yang menunjukkan apakah kriteria 'benefit' atau 'cost'
     * @return array Alternatif yang diranking dengan skor
     */
    public static function hitung(array $alternatif, array $preferensiKriteria, array $tipeKriteria = [])
    {
        if (empty($alternatif) || empty($preferensiKriteria)) {
            return [];
        }

        // Dapatkan total jumlah kriteria
        $totalKriteria = count($preferensiKriteria);

        // Hitung bobot ROC berdasarkan preferensi mahasiswa
        $bobot = self::hitungBobotROC($preferensiKriteria, $totalKriteria);

        // Set tipe kriteria default jika tidak disediakan (semua benefit secara default)
        $tipeKriteriaDefault = array_fill_keys(array_keys($preferensiKriteria), 'benefit');
        $tipeKriteria = array_merge($tipeKriteriaDefault, $tipeKriteria);

        // Langkah 1: Sistem Rasio
        $skorRasio = self::sistemRasio($alternatif, $bobot, $tipeKriteria);

        // Langkah 2: Sistem Reference Point
        $skorReferensi = self::sistemReferensi($alternatif, $bobot, $tipeKriteria);

        // Langkah 3: Full Multiplicative Form
        $skorMultiplikatif = self::sistemMultiplikatif($alternatif, $tipeKriteria);

        // Langkah 4: Agregasi ranking akhir
        $rankingAkhir = self::agregasiRanking($skorRasio, $skorReferensi, $skorMultiplikatif);

        return $rankingAkhir;
    }

    /**
     * Menghitung bobot ROC berdasarkan preferensi mahasiswa
     */
    private static function hitungBobotROC(array $preferensiKriteria, int $totalKriteria): array
    {
        $bobot = [];

        foreach ($preferensiKriteria as $kriteria => $ranking) {
            $bobot[$kriteria] = ROC::getWeight($ranking, $totalKriteria);
        }

        return $bobot;
    }

    /**
     * Normalisasi matriks keputusan
     */
    private static function normalisasiMatriks(array $alternatif): array
    {
        $ternormalisasi = [];
        $kriteria = array_keys(reset($alternatif));

        // Hitung jumlah kuadrat untuk setiap kriteria
        $jumlahKuadrat = [];
        foreach ($kriteria as $namaKriteria) {
            $jumlahKuadrat[$namaKriteria] = 0;
            foreach ($alternatif as $alt) {
                $jumlahKuadrat[$namaKriteria] += pow($alt[$namaKriteria], 2);
            }
            $jumlahKuadrat[$namaKriteria] = sqrt($jumlahKuadrat[$namaKriteria]);
        }

        // Normalisasi setiap nilai
        foreach ($alternatif as $namaAlt => $nilaiAlt) {
            foreach ($kriteria as $namaKriteria) {
                $ternormalisasi[$namaAlt][$namaKriteria] = $nilaiAlt[$namaKriteria] / $jumlahKuadrat[$namaKriteria];
            }
        }

        return $ternormalisasi;
    }

    /**
     * Sistem Rasio MOORA
     */
    private static function sistemRasio(array $alternatif, array $bobot, array $tipeKriteria): array
    {
        $ternormalisasi = self::normalisasiMatriks($alternatif);
        $skor = [];

        foreach ($ternormalisasi as $namaAlt => $nilaiAlt) {
            $nilaiSkor = 0;
            foreach ($nilaiAlt as $kriteria => $nilai) {
                $nilaiBerbobot = $nilai * $bobot[$kriteria];

                if ($tipeKriteria[$kriteria] === 'benefit') {
                    $nilaiSkor += $nilaiBerbobot;
                } else { // kriteria cost
                    $nilaiSkor -= $nilaiBerbobot;
                }
            }
            $skor[$namaAlt] = $nilaiSkor;
        }

        // Urutkan berdasarkan skor (menurun)
        arsort($skor);

        return $skor;
    }

    /**
     * Sistem Reference Point MOORA
     */
    private static function sistemReferensi(array $alternatif, array $bobot, array $tipeKriteria): array
    {
        $ternormalisasi = self::normalisasiMatriks($alternatif);

        // Cari titik referensi (max untuk benefit, min untuk cost)
        $titikReferensi = [];
        $kriteria = array_keys(reset($ternormalisasi));

        foreach ($kriteria as $namaKriteria) {
            $nilai = array_column($ternormalisasi, $namaKriteria);

            if ($tipeKriteria[$namaKriteria] === 'benefit') {
                $titikReferensi[$namaKriteria] = max($nilai);
            } else {
                $titikReferensi[$namaKriteria] = min($nilai);
            }
        }

        // Hitung jarak dari titik referensi
        $skor = [];
        foreach ($ternormalisasi as $namaAlt => $nilaiAlt) {
            $jarakMaksimal = 0;
            foreach ($nilaiAlt as $kriteria => $nilai) {
                $nilaiBerbobot = $nilai * $bobot[$kriteria];
                $jarak = abs($titikReferensi[$kriteria] * $bobot[$kriteria] - $nilaiBerbobot);
                $jarakMaksimal = max($jarakMaksimal, $jarak);
            }
            $skor[$namaAlt] = -$jarakMaksimal; // Negatif karena jarak yang lebih kecil lebih baik
        }

        // Urutkan berdasarkan skor (menurun)
        arsort($skor);

        return $skor;
    }

    /**
     * Sistem Full Multiplicative Form MOORA
     */
    private static function sistemMultiplikatif(array $alternatif, array $tipeKriteria): array
    {
        $skor = [];

        foreach ($alternatif as $namaAlt => $nilaiAlt) {
            $produkBenefit = 1;
            $produkCost = 1;

            foreach ($nilaiAlt as $kriteria => $nilai) {
                if ($tipeKriteria[$kriteria] === 'benefit') {
                    $produkBenefit *= $nilai;
                } else {
                    $produkCost *= $nilai;
                }
            }

            // Hindari pembagian dengan nol
            if ($produkCost == 0) {
                $produkCost = 0.0001;
            }

            $skor[$namaAlt] = $produkBenefit / $produkCost;
        }

        // Urutkan berdasarkan skor (menurun)
        arsort($skor);

        return $skor;
    }

    /**
     * Agregasi ranking akhir menggunakan teori dominasi
     */
    private static function agregasiRanking(array $skorRasio, array $skorReferensi, array $skorMultiplikatif): array
    {
        $alternatif = array_keys($skorRasio);
        $ranking = [];

        // Dapatkan ranking untuk setiap metode
        $rankingRasio = array_flip(array_keys($skorRasio));
        $rankingReferensi = array_flip(array_keys($skorReferensi));
        $rankingMultiplikatif = array_flip(array_keys($skorMultiplikatif));

        // Hitung rata-rata ranking untuk setiap alternatif
        foreach ($alternatif as $alt) {
            $rataRataRanking = ($rankingRasio[$alt] + $rankingReferensi[$alt] + $rankingMultiplikatif[$alt]) / 3;
            $ranking[$alt] = [
                'rata_rata_ranking' => $rataRataRanking,
                'skor_rasio' => $skorRasio[$alt],
                'skor_referensi' => $skorReferensi[$alt],
                'skor_multiplikatif' => $skorMultiplikatif[$alt],
                'ranking_rasio' => $rankingRasio[$alt] + 1,
                'ranking_referensi' => $rankingReferensi[$alt] + 1,
                'ranking_multiplikatif' => $rankingMultiplikatif[$alt] + 1,
            ];
        }

        // Urutkan berdasarkan rata-rata ranking (menaik)
        uasort($ranking, function ($a, $b) {
            return $a['rata_rata_ranking'] <=> $b['rata_rata_ranking'];
        });

        return $ranking;
    }

    /**
     * Method helper untuk menyiapkan data magang untuk perhitungan MultiMOORA
     *
     * @param array $dataMagang Array data magang dari database
     * @param array $preferensiMahasiswa Preferensi mahasiswa dari tabel preferensi_mahasiswa
     * @return array Data yang telah diformat siap untuk perhitungan MultiMOORA
     */
    public static function siapkanDataMagang(array $dataMagang, array $preferensiMahasiswa): array
    {
        $alternatif = [];
        $preferensiKriteria = [];
        $tipeKriteria = [
            'bidang_pekerjaan' => 'benefit',
            'lokasi' => 'benefit',
            'reputasi' => 'benefit',
            'uang_saku' => 'benefit',
            'open_remote' => 'benefit'
        ];

        // Ekstrak preferensi kriteria (ranking) dari preferensi mahasiswa
        foreach ($preferensiMahasiswa as $kriteria => $idKriteria) {
            if (in_array($kriteria, ['bidang_pekerjaan', 'lokasi', 'reputasi', 'uang_saku', 'open_remote'])) {
                // Asumsi ranking disimpan di tabel kriteria, Anda mungkin perlu mengambilnya
                // Untuk saat ini, menggunakan mapping sederhana
                $preferensiKriteria[$kriteria] = $idKriteria; // Ini seharusnya nilai ranking
            }
        }

        // Format data alternatif
        foreach ($dataMagang as $magang) {
            $namaAlt = $magang['nama'] ?? 'Magang_' . $magang['id'];

            $alternatif[$namaAlt] = [
                'bidang_pekerjaan' => $magang['skor_bidang_cocok'] ?? 1, // Anda perlu mendefinisikan cara menghitung skor ini
                'lokasi' => $magang['skor_lokasi'] ?? 1, // Anda perlu mendefinisikan cara menghitung skor ini
                'reputasi' => $magang['rating'] ?? 1,
                'uang_saku' => $magang['skor_gaji'] ?? 1, // Anda perlu mendefinisikan cara menghitung skor ini
                'open_remote' => $magang['skor_remote'] ?? 1, // Anda perlu mendefinisikan cara menghitung skor ini
            ];
        }

        return [
            'alternatif' => $alternatif,
            'preferensi_kriteria' => $preferensiKriteria,
            'tipe_kriteria' => $tipeKriteria
        ];
    }
}
