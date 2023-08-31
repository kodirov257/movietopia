<?php

namespace Database\Factories;

use App\Models\Genre;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('en_US')->unique()->firstName();
        $slug = SlugService::createSlug(Genre::class, 'slug', $name);

        return [
            'name_uz' => fake('en_US')->unique()->firstName(),
            'name_uz_cy' => fake('ru_RU')->unique()->firstName(),
            'name_ru' => fake('ru_RU')->unique()->firstName(),
            'name_en' => $name,
            'slug' => $slug,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
