<?php

namespace Database\Factories\Celebrity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class TrademarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $trademarkEn = fake('en_US')->unique()->text();
        $trademarkRu = fake('ru_RU')->unique()->text();

        return [
            'trademark_uz' => $trademarkEn,
            'trademark_uz_cy' => $trademarkRu,
            'trademark_ru' => $trademarkRu,
            'trademark_en' => $trademarkEn,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
