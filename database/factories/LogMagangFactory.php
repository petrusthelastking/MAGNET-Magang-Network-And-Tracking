<?php

namespace Database\Factories;

use App\Models\KontrakMagang;
use App\Models\LogMagang;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LogMagang>
 */
class LogMagangFactory extends Factory
{
    protected $model = LogMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kontrak = KontrakMagang::inRandomOrder()->first();

        $start = Carbon::today()->addHours(7);
        $end = Carbon::today()->addHours(17);

        $startTime = $this->faker->dateTimeBetween($start, $end);
        $endTime = $this->faker->dateTimeBetween($startTime, $end);

        return [
            'kontrak_magang_id' => $kontrak->value('id'),
            'kegiatan' => $this->faker->sentence(),
            'tanggal' => $this->faker->dateTimeBetween(
                $kontrak->value('waktu_awal'),
                $kontrak->value('waktu_akhir')
            ),
            'jam_masuk' => $startTime->format('H:i:s'),
            'jam_keluar' => $endTime->format('H:i:s')
        ];
    }
}
