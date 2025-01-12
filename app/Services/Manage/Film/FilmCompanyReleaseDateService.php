<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\FilmCompanyReleaseDates\CreateRequest;
use App\Http\Requests\Admin\Film\FilmCompanyReleaseDates\UpdateRequest;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmCompany;
use App\Models\Film\FilmReleaseDate;
use Illuminate\Support\Facades\DB;

class FilmCompanyReleaseDateService
{
    /**
     * @throws \Throwable
     */
    public function add(int $filmId, int $filmCompanyId, CreateRequest $request): FilmReleaseDate
    {
        $film = Film::findOrFail($filmId);
        /* @var $filmCompany FilmCompany */
        $filmCompany = $film->filmCompanies()->findOrFail($filmCompanyId);
        $country = CountryRegion::findOrFail($request->country);

        DB::beginTransaction();
        try {
            $filmReleaseDate = $filmCompany->releaseDates()->create([
                'country_id' => $country->id,
                'details_uz' => $request->details_uz,
                'details_uz_cy' => $request->details_uz_cy,
                'details_ru' => $request->details_ru,
                'details_en' => $request->details_en,
                'release_date' => $request->release_date,
            ]);

            $this->sortReleaseDates($filmCompany);

            DB::commit();

            return $filmReleaseDate;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $filmId, int $filmCompanyId, int $releaseDateId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($filmId);
        /* @var $filmCompany FilmCompany */
        $filmCompany = $film->filmCompanies()->findOrFail($filmCompanyId);
        $country = CountryRegion::findOrFail($request->country);
        $filmReleaseDate = $filmCompany->releaseDates()->findOrFail($releaseDateId);

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
    public function remove(int $filmId, int $filmCompanyId, int $releaseDateId): void
    {
        $film = Film::findOrFail($filmId);
        /* @var $filmCompany FilmCompany */
        $filmCompany = $film->filmCompanies()->findOrFail($filmCompanyId);
        $filmReleaseDate = $filmCompany->releaseDates()->findOrFail($releaseDateId);

        DB::beginTransaction();
        try {
            $filmReleaseDate->delete();

            $this->sortReleaseDates($filmCompany);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveReleaseDateToFirst(int $companyId, int $releaseDateId): void
    {
        $company = FilmCompany::findOrFail($companyId);
        $filmReleaseDates = $company->releaseDates;

        foreach ($filmReleaseDates as $i => $filmReleaseDate) {
            if ($filmReleaseDate->isIdEqualTo($releaseDateId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($filmReleaseDates[$j - 1])) {
                        break(1);
                    }

                    $prev = $filmReleaseDates[$j - 1];
                    $filmReleaseDates[$j - 1] = $filmReleaseDates[$j];
                    $filmReleaseDates[$j] = $prev;
                }
                $company->releaseDates = $filmReleaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($company);
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
    public function moveReleaseDateUp(int $companyId, int $releaseDateId): void
    {
        $company = FilmCompany::findOrFail($companyId);
        $filmReleaseDates = $company->releaseDates;

        foreach ($filmReleaseDates as $i => $filmReleaseDate) {
            if ($filmReleaseDate->isIdEqualTo($releaseDateId)) {
                if (!isset($filmReleaseDates[$i - 1])) {
                    $count = count($filmReleaseDates);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $filmReleaseDates[$j - 1];
                        $filmReleaseDates[$j - 1] = $filmReleaseDates[$j];
                        $filmReleaseDates[$j] = $next;
                    }
                } else {
                    $previous = $filmReleaseDates[$i - 1];
                    $filmReleaseDates[$i - 1] = $filmReleaseDate;
                    $filmReleaseDates[$i] = $previous;
                }
                $company->releaseDates = $filmReleaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($company);
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
    public function moveReleaseDateDown(int $companyId, int $releaseDateId): void
    {
        $company = FilmCompany::findOrFail($companyId);
        $filmReleaseDates = $company->releaseDates;

        foreach ($filmReleaseDates as $i => $filmReleaseDate) {
            if ($filmReleaseDate->isIdEqualTo($releaseDateId)) {
                if (!isset($filmReleaseDates[$i + 1])) {
                    $last = $filmReleaseDates->last();
                    $count = count($filmReleaseDates);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $filmReleaseDates[$j] = $filmReleaseDates[$j - 1];
                    }

                    $filmReleaseDates[$j] = $last;
                } else {
                    $next = $filmReleaseDates[$i + 1];
                    $filmReleaseDates[$i + 1] = $filmReleaseDate;
                    $filmReleaseDates[$i] = $next;
                }
                $company->releaseDates = $filmReleaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($company);
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
    public function moveReleaseDateToLast(int $companyId, int $releaseDateId): void
    {
        $company = FilmCompany::findOrFail($companyId);
        $filmReleaseDates = $company->releaseDates;

        foreach ($filmReleaseDates as $i => $filmReleaseDate) {
            if ($filmReleaseDate->isIdEqualTo($releaseDateId)) {
                $count = count($filmReleaseDates);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($filmReleaseDates[$j + 1])) {
                        break(1);
                    }

                    $next = $filmReleaseDates[$j + 1];
                    $filmReleaseDates[$j + 1] = $filmReleaseDates[$j];
                    $filmReleaseDates[$j] = $next;
                }
                $company->releaseDates = $filmReleaseDates;

                DB::beginTransaction();
                try {
                    $this->sortReleaseDates($company);
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
    private function sortReleaseDates(FilmCompany $company): void
    {
        foreach ($company->releaseDates as $i => $releaseDate) {
            $releaseDate->setSort($i + 1);
            $releaseDate->saveOrFail();
        }
    }
}
