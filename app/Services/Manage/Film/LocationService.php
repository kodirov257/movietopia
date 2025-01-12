<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Locations\CreateRequest;
use App\Http\Requests\Admin\Film\Locations\UpdateRequest;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmLocation;
use Illuminate\Support\Facades\DB;

class LocationService
{
    /**
     * @throws \Throwable
     */
    public function addLocation(int $id, CreateRequest $request): FilmLocation
    {
        $film = Film::findOrFail($id);
        $location = CountryRegion::findOrFail($request->location_id);

        DB::beginTransaction();
        try {
            $filmLocation = $film->filmLocations()->create([
                'location_id' => $location->id,
                'details_uz' => $request->details_uz,
                'details_uz_cy' => $request->details_uz_cy,
                'details_ru' => $request->details_ru,
                'details_en' => $request->details_en,
            ]);

            $this->sortLocations($film);

            DB::commit();

            return $filmLocation;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateLocation(int $id, int $locationId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $filmLocation = $film->filmLocations()->findOrFail($locationId);
        $location = CountryRegion::findOrFail($request->location_id);

        $filmLocation->update([
            'location_id' => $location->id,
            'details_uz' => $request->details_uz,
            'details_uz_cy' => $request->details_uz_cy,
            'details_ru' => $request->details_ru,
            'details_en' => $request->details_en,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $locationId): void
    {
        $film = Film::findOrFail($id);
        $filmLocation = $film->filmLocations()->findOrFail($locationId);

        DB::beginTransaction();
        try {
            $filmLocation->delete();

            $this->sortLocations($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveLocationToFirst(int $id, int $locationId): void
    {
        $film = Film::findOrFail($id);
        $filmLocations = $film->filmLocations;

        foreach ($filmLocations as $i => $filmLocation) {
            if ($filmLocation->isIdEqualTo($locationId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($filmLocations[$j - 1])) {
                        break(1);
                    }

                    $prev = $filmLocations[$j - 1];
                    $filmLocations[$j - 1] = $filmLocations[$j];
                    $filmLocations[$j] = $prev;
                }
                $film->filmLocations = $filmLocations;

                DB::beginTransaction();
                try {
                    $this->sortLocations($film);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveLocationUp(int $id, int $locationId): void
    {
        $film = Film::findOrFail($id);
        $filmLocations = $film->filmLocations;

        foreach ($filmLocations as $i => $filmLocation) {
            if ($filmLocation->isIdEqualTo($locationId)) {
                if (!isset($filmLocations[$i - 1])) {
                    $count = count($filmLocations);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $filmLocations[$j - 1];
                        $filmLocations[$j - 1] = $filmLocations[$j];
                        $filmLocations[$j] = $next;
                    }
                } else {
                    $previous = $filmLocations[$i - 1];
                    $filmLocations[$i - 1] = $filmLocation;
                    $filmLocations[$i] = $previous;
                }
                $film->filmLocations = $filmLocations;

                DB::beginTransaction();
                try {
                    $this->sortLocations($film);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveLocationDown(int $id, int $locationId): void
    {
        $film = Film::findOrFail($id);
        $filmLocations = $film->filmLocations;

        foreach ($filmLocations as $i => $filmLocation) {
            if ($filmLocation->isIdEqualTo($locationId)) {
                if (!isset($filmLocations[$i + 1])) {
                    $last = $filmLocations->last();
                    $count = count($filmLocations);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $filmLocations[$j] = $filmLocations[$j - 1];
                    }

                    $filmLocations[$j] = $last;
                } else {
                    $next = $filmLocations[$i + 1];
                    $filmLocations[$i + 1] = $filmLocation;
                    $filmLocations[$i] = $next;
                }
                $film->filmLocations = $filmLocations;

                DB::beginTransaction();
                try {
                    $this->sortLocations($film);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveLocationToLast(int $id, int $locationId): void
    {
        $film = Film::findOrFail($id);
        $filmLocations = $film->filmLocations;

        foreach ($filmLocations as $i => $filmLocation) {
            if ($filmLocation->isIdEqualTo($locationId)) {
                $count = count($filmLocations);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($filmLocations[$j + 1])) {
                        break(1);
                    }

                    $next = $filmLocations[$j + 1];
                    $filmLocations[$j + 1] = $filmLocations[$j];
                    $filmLocations[$j] = $next;
                }
                $film->filmLocations = $filmLocations;

                DB::beginTransaction();
                try {
                    $this->sortLocations($film);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    /**
     * @throws \Throwable
     */
    private function sortLocations(Film $film): void
    {
        foreach ($film->filmLocations as $i => $filmLocation) {
            $filmLocation->setSort($i + 1);
            $filmLocation->saveOrFail();
        }
    }
}
