<?php

namespace Database\Factories;

use App\Models\KriteriaBidangIndustri;
use App\Models\KriteriaJenisMagang;
use App\Models\KriteriaLokasiMagang;
use App\Models\KriteriaOpenRemote;
use App\Models\KriteriaPekerjaan;
use App\Models\Mahasiswa;
use App\Models\PreferensiMahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreferensiMahasiswa>
 */
class PreferensiMahasiswaFactory extends Factory
{
    protected $model = PreferensiMahasiswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mahasiswa_id' => fn() => Mahasiswa::inRandomOrder()->value('id'),
            'kriteria_pekerjaan_id' => KriteriaPekerjaan::factory(),
            'kriteria_bidang_industri_id' => KriteriaBidangIndustri::factory(),
            'kriteria_lokasi_magang_id' => KriteriaLokasiMagang::factory(),
            'kriteria_jenis_magang_id' => KriteriaJenisMagang::factory(),
            'kriteria_open_remote_id' => KriteriaOpenRemote::factory(),
        ];
    }
}
