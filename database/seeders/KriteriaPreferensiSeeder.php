<?php

namespace Database\Seeders;

use App\Enums\DecisionMakingEnum;
use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaBidangIndustri;
use App\Models\KriteriaJenisMagang;
use App\Models\KriteriaLokasiMagang;
use App\Models\KriteriaOpenRemote;
use App\Models\KriteriaPekerjaan;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class KriteriaPreferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaIds = Mahasiswa::orderBy('id')->pluck('id');

        // foreach ($mahasiswaIds as $index => $mhs_id) {
        //     $ranks = collect(range(1, DecisionMakingEnum::totalCriteria->value))
        //         ->shuffle($seed = $index)
        //         ->values();

        //     KriteriaBidangIndustri::factory()->forUser($mhs_id)->rank($ranks[0])->create();
        //     KriteriaJenisMagang::factory()->forUser($mhs_id)->rank($ranks[1])->create();
        //     KriteriaLokasiMagang::factory()->forUser($mhs_id)->rank($ranks[2])->create();
        //     KriteriaOpenRemote::factory()->forUser($mhs_id)->rank($ranks[3])->create();
        //     KriteriaPekerjaan::factory()->forUser($mhs_id)->rank($ranks[4])->create();
        // }

        KriteriaBidangIndustri::create([
            'bidang_industri_id' => 11,
            'mahasiswa_id' => 1,
            'rank' => 4,
            'bobot' => ROC::getWeight(4, DecisionMakingEnum::totalCriteria->value)
        ]);

        KriteriaJenisMagang::create([
            'mahasiswa_id' => 1,
            'jenis_magang' => 'tidak berbayar',
            'rank' => 3,
            'bobot' => ROC::getWeight(3, DecisionMakingEnum::totalCriteria->value)
        ]);

        KriteriaLokasiMagang::create([
            'mahasiswa_id' => 1,
            'lokasi_magang_id' => 11,
            'rank' => 1,
            'bobot' => ROC::getWeight(1, DecisionMakingEnum::totalCriteria->value)
        ]);

        KriteriaOpenRemote::create([
            'mahasiswa_id' => 1,
            'open_remote' => 'ya',
            'rank' => 2,
            'bobot' => ROC::getWeight(2, DecisionMakingEnum::totalCriteria->value)
        ]);

        KriteriaPekerjaan::create([
            'mahasiswa_id' => 1,
            'pekerjaan_id' => 12,
            'rank' => 5,
            'bobot' => ROC::getWeight(5, DecisionMakingEnum::totalCriteria->value)
        ]);
    }
}
