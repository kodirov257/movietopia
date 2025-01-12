<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\FilmReleaseDates\CreateRequest;
use App\Http\Requests\Admin\Film\FilmReleaseDates\UpdateRequest;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmCompany;
use App\Models\Film\FilmReleaseDate;
use Illuminate\Support\Facades\DB;

class FilmReleaseDateService
{
    /**
     * @throws \Throwable
     */
    public function add(int $filmId, CreateRequest $request): FilmReleaseDate
    {
        $film = Film::findOrFail($filmId);
        $country = CountryRegion::findOrFail($request->country);

        DB::beginTransaction();
        try {
            $filmReleaseDate = $film->releaseDates()->create([
                'country_id' => $country->id,
                'details_uz' => $request->details_uz,
                'details_uz_cy' => $request->details_uz_cy,
                'details_ru' => $request->details_ru,
                'details_en' => $request->details_en,
                'release_date' => $request->release_date,
            ]);

            $this->sortReleaseDates($film);

            DB::commit();

            return $filmReleaseDate;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $filmId, int $releaseDateId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($filmId);
        $country = CountryRegion::findOrFail($request->country);
        $filmReleaseDate = $film->releaseDates()->findOrFail($releaseDateId);

        $filmReleaseDate->update([
            'country_id' => $country->id,
            'details_uz' => $request->details_uz,
            'details_uz_cy' => $request->details_uz_cy,
            'details_ru' => $request->details_ru,
            'details_en' => $request->details_en,
            'release_date' => $request->release_date,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $filmId, int $releaseDateId): void
    {
        $film = Film::findOrFail($filmId);
        $filmReleaseDate = $film->releaseDates()->findOrFail($releaseDateId);

        DB::beginTransaction();
        try {
            $filmReleaseDate->delete();

            $this->sortReleaseDates($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveReleaseDateToFirst(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $releaseDates = $film->releaseDates;

        foreach ($releaseDates as $i => $releaseDate) {
            if ($releaseDate->isIdEqualTo($companyId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($releaseDates[$j - 1])) {
                        break(1);
                    }

                    $prev = $releaseDates[$j - 1];
                    $releaseDates[$j - 1] = $releaseDates[$j];
                    $releaseDates[$j] = $prev;
                }
                $film->releaseDates = $releaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($film);
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
    public function moveReleaseDateUp(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $releaseDates = $film->releaseDates;

        foreach ($releaseDates as $i => $releaseDate) {
            if ($releaseDate->isIdEqualTo($companyId)) {
                if (!isset($releaseDates[$i - 1])) {
                    $count = count($releaseDates);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $releaseDates[$j - 1];
                        $releaseDates[$j - 1] = $releaseDates[$j];
                        $releaseDates[$j] = $next;
                    }
                } else {
                    $previous = $releaseDates[$i - 1];
                    $releaseDates[$i - 1] = $releaseDate;
                    $releaseDates[$i] = $previous;
                }
                $film->releaseDates = $releaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($film);
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
    public function moveReleaseDateDown(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $releaseDates = $film->releaseDates;

        foreach ($releaseDates as $i => $releaseDate) {
            if ($releaseDate->isIdEqualTo($companyId)) {
                if (!isset($releaseDates[$i + 1])) {
                    $last = $releaseDates->last();
                    $count = count($releaseDates);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $releaseDates[$j] = $releaseDates[$j - 1];
                    }

                    $releaseDates[$j] = $last;
                } else {
                    $next = $releaseDates[$i + 1];
                    $releaseDates[$i + 1] = $releaseDate;
                    $releaseDates[$i] = $next;
                }
                $film->releaseDates = $releaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($film);
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
    public function moveReleaseDateToLast(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $releaseDates = $film->releaseDates;

        foreach ($releaseDates as $i => $releaseDate) {
            if ($releaseDate->isIdEqualTo($companyId)) {
                $count = count($releaseDates);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($releaseDates[$j + 1])) {
                        break(1);
                    }

                    $next = $releaseDates[$j + 1];
                    $releaseDates[$j + 1] = $releaseDates[$j];
                    $releaseDates[$j] = $next;
                }
                $film->releaseDates = $releaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($film);
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
    private function sortReleaseDates(Film $film): void
    {
        foreach ($film->releaseDates as $i => $releaseDate) {
            $releaseDate->setSort($i + 1);
            $releaseDate->saveOrFail();
        }
    }
}
