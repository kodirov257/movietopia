<?php

namespace Database\Seeders;

use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Quote;
use App\Models\Celebrity\Trademark;
use App\Models\Celebrity\Trivia;
use Database\Factories\Celebrity\TriviaFactory;
use Illuminate\Database\Seeder;

class CelebritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Celebrity::factory()
            ->has(Trivia::factory()->count(random_int(1, 10)))
            ->has(Trademark::factory()->count(random_int(1, 10)))
            ->has(Quote::factory()->count(random_int(1, 10)))
            ->count(50)
            ->create();
    }
}
