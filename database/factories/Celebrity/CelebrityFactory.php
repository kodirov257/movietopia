<?php

namespace Database\Factories\Celebrity;

use App\Entity\Meta;
use App\Models\Celebrity\Celebrity;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Celebrity>
 */
class CelebrityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement([Celebrity::MALE, Celebrity::FEMALE]);
        $firstNameEn = $gender === Celebrity::MALE ? fake('en_US')->firstNameMale() : fake('en_US')->firstNameFemale();
        $lastNameEn = fake('en_US')->lastName();
        $firstNameRu = $gender === Celebrity::MALE ? fake('ru_RU')->firstNameMale() : fake('ru_RU')->firstNameFemale();
        $lastNameRu = fake('ru_RU')->lastName();
        $fullName = $firstNameEn . ' ' . $lastNameEn;
        $slug = SlugService::createSlug(Celebrity::class, 'slug', $fullName);
        $meta = new Meta($fullName, $fullName, $fullName);

        return [
            'first_name_uz' => $firstNameEn,
            'first_name_uz_cy' => $firstNameRu,
            'first_name_ru' => $firstNameRu,
            'first_name_en' => $firstNameEn,
            'last_name_uz' => $lastNameEn,
            'last_name_uz_cy' => $lastNameRu,
            'last_name_ru' => $lastNameRu,
            'last_name_en' => $lastNameEn,
            'professions_uz' => json_encode([fake('en_US')->firstName()], JSON_THROW_ON_ERROR),
            'professions_uz_cy' => json_encode([fake('ru_RU')->firstName()], JSON_THROW_ON_ERROR),
            'professions_ru' => json_encode([fake('ru_RU')->firstName()], JSON_THROW_ON_ERROR),
            'professions_en' => json_encode([fake('en_US')->firstName()], JSON_THROW_ON_ERROR),
            'biography_uz' => fake('en_US')->text(500),
            'biography_uz_cy' => fake('ru_RU')->text(500),
            'biography_ru' => fake('ru_RU')->text(500),
            'biography_en' => fake('en_US')->text(500),
            'birth_name' => fake()->name($gender),
            'original_name' => fake()->name($gender),
            'gender' => $gender,
            'height_foot' => fake()->randomFloat(2, 5, 7),
            'height_meter' => fake()->randomFloat(2, 1.2, 2),
            'slug' => $slug,
            'meta_json' => $meta,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
