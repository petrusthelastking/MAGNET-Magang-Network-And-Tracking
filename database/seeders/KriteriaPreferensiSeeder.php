<?php

namespace Database\Seeders;

use App\Enums\DecisionMakingEnum;
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
        $mahasiswaIds = Mahasiswa::inRandomOrder()->pluck('id');

        foreach ($mahasiswaIds as $mhs_id) {
            $ranks = collect(range(1, DecisionMakingEnum::totalCriteria->value))
                ->shuffle()
                ->values();

            KriteriaBidangIndustri::factory()->forUser($mhs_id)->rank($ranks[0])->create();
            KriteriaJenisMagang::factory()->forUser($mhs_id)->rank($ranks[1])->create();
            KriteriaLokasiMagang::factory()->forUser($mhs_id)->rank($ranks[2])->create();
            KriteriaOpenRemote::factory()->forUser($mhs_id)->rank($ranks[3])->create();
            KriteriaPekerjaan::factory()->forUser($mhs_id)->rank($ranks[4])->create();
        }
    }
}
