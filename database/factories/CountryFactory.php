<?php

namespace Database\Factories;

use App\Entity\Meta;
use App\Models\Country;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('en_US')->unique()->country();
        $slug = SlugService::createSlug(Country::class, 'slug', $name);
        $meta = new Meta($name, $name, $name);

        return [
            'name_uz' => $name,
            'name_uz_cy' => fake('ru_RU')->unique()->country(),
            'name_ru' => fake('ru_RU')->unique()->country(),
            'name_en' => $name,
            'slug' => $slug,
            'meta_json' => $meta,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
