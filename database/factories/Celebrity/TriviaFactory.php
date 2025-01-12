<?php

namespace Database\Factories\Celebrity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class TriviaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $triviaEn = fake('en_US')->unique()->text();
        $triviaRu = fake('ru_RU')->unique()->text();

        return [
            'trivia_uz' => $triviaEn,
            'trivia_uz_cy' => $triviaRu,
            'trivia_ru' => $triviaRu,
            'trivia_en' => $triviaEn,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
