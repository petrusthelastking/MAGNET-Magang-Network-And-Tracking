<?php

namespace Database\Factories;

use App\Models\DosenPembimbing;
use App\Models\KontrakMagang;
use App\Models\LowonganMagang;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KontrakMagang>
 */
class KontrakMagangFactory extends Factory
{
    protected $model = KontrakMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $finishDate = $this->faker->dateTimeBetween($startDate, '+1 year');

        return [
            'mahasiswa_id' => fn() => Mahasiswa::inRandomOrder()->value('id'),
            'dosen_id' => fn() => DosenPembimbing::inRandomOrder()->value('id'),
            'lowongan_magang_id' => fn() => LowonganMagang::inRandomOrder()->value('id'),
            'waktu_awal' => $startDate,
            'waktu_akhir' => $finishDate
        ];
    }
}
