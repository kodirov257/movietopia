<?php

namespace Database\Factories;

use App\Entity\Meta;
use App\Models\CountryRegion;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryRegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('en_US')->country();
        $slug = SlugService::createSlug(CountryRegion::class, 'slug', $name);
        $meta = new Meta($name, $name, $name);

        return [
            'name_uz' => $name,
            'name_uz_cy' => fake('ru_RU')->country(),
            'name_ru' => fake('ru_RU')->country(),
            'name_en' => $name,
            'type' => CountryRegion::COUNTRY,
            'slug' => $slug,
            'meta_json' => $meta,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
