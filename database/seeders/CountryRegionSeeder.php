<?php

namespace Database\Seeders;

use App\Models\CountryRegion;
use Illuminate\Database\Seeder;

class CountryRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CountryRegion::factory()
            ->count(50)
            ->create()
            /*->each(function (CountryRegion $country) {
                CountryRegion::factory()
                    ->count(random_int(1, 5))
                    ->create([
                        'type' => CountryRegion::CITY,
                        'parent_id' => $country->id,
                    ]);

                CountryRegion::factory()
                    ->count(random_int(1, 5))
                    ->create([
                        'type' => CountryRegion::REGION,
                        'parent_id' => $country->id,
                    ])->each(function (CountryRegion $state) {
                        CountryRegion::factory()->count(random_int(1, 5))->create([
                            'type' => CountryRegion::CITY,
                            'parent_id' => $state->id,
                        ]);
                    });
            })*/;
    }
}
