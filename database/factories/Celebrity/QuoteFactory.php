<?php

namespace Database\Factories\Celebrity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quoteEn = fake('en_US')->unique()->text();
        $quoteRu = fake('ru_RU')->unique()->text();

        return [
            'quote_uz' => $quoteEn,
            'quote_uz_cy' => $quoteRu,
            'quote_ru' => $quoteRu,
            'quote_en' => $quoteEn,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
