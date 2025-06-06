<?php

namespace Database\Factories;

use App\Enums\DecisionMakingEnum;
use App\Helpers\DecisionMaking\ROC;
use App\Models\BidangIndustri;
use App\Models\KriteriaBidangIndustri;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaBidangIndustri>
 */
class KriteriaBidangIndustriFactory extends Factory
{
    protected $model = KriteriaBidangIndustri::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, DecisionMakingEnum::totalCriteria->value);

        return [
            'bidang_industri_id' => fn() => BidangIndustri::inRandomOrder()->value('id'),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, DecisionMakingEnum::totalCriteria->value)
        ];
    }
}
