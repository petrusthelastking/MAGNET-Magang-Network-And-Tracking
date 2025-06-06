<?php

namespace Database\Factories;

use App\Enums\DecisionMakingEnum;
use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaPekerjaan;
use App\Models\Pekerjaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaPekerjaan>
 */
class KriteriaPekerjaanFactory extends Factory
{
    protected $model = KriteriaPekerjaan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, DecisionMakingEnum::totalCriteria->value);

        return [
            'pekerjaan_id' => fn() => Pekerjaan::inRandomOrder()->value('id'),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, DecisionMakingEnum::totalCriteria->value)
        ];
    }
}
