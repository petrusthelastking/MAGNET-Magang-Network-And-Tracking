<?php

namespace Database\Factories;

use App\Enums\DecisionMakingEnum;
use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaPekerjaan;
use App\Models\Mahasiswa;
use App\Models\Pekerjaan;
use App\Traits\BaseKriteriaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaPekerjaan>
 */
class KriteriaPekerjaanFactory extends Factory
{
    use BaseKriteriaFactory;

    protected $model = KriteriaPekerjaan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $pekerjaanIds = null;
        static $mahasiswaIds = null;

        $pekerjaanIds ??= Pekerjaan::orderBy('id')->pluck('id')->toArray();
        $mahasiswaIds ??= Mahasiswa::orderBy('id')->pluck('id')->toArray();

        $rank = $this->faker->numberBetween(1, DecisionMakingEnum::totalCriteria->value);

        return [
            'pekerjaan_id' => $this->faker->randomElement($pekerjaanIds),
            'mahasiswa_id' => $this->faker->randomElement($mahasiswaIds),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, DecisionMakingEnum::totalCriteria->value),
        ];
    }


    public function configure()
    {
        return $this->withBobotCalculation();
    }
}
