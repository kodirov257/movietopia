<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Companies\CreateRequest;
use App\Http\Requests\Admin\Film\Companies\UpdateRequest;
use App\Models\Company;
use App\Models\Film\Film;
use App\Models\Film\FilmCompany;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    /**
     * @throws \Throwable
     */
    public function addCompany(int $id, CreateRequest $request): FilmCompany
    {
        $film = Film::findOrFail($id);
        $company = Company::findOrFail($request->company_id);

        DB::beginTransaction();
        try {
            $filmCompany = $film->filmCompanies()->create([
                'company_id' => $company->id,
                'type' => $request->type,
                'details_uz' => $request->details_uz,
                'details_uz_cy' => $request->details_uz_cy,
                'details_ru' => $request->details_ru,
                'details_en' => $request->details_en,
                'date' => $request->date,
            ]);

            $this->sortCompanies($film);

            DB::commit();

            return $filmCompany;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateCompany(int $id, int $companyId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $filmCompany = $film->filmCompanies()->findOrFail($companyId);
        $company = Company::findOrFail($request->company_id);

        $filmCompany->update([
            'company_id' => $company->id,
            'type' => $request->type,
            'details_uz' => $request->details_uz,
            'details_uz_cy' => $request->details_uz_cy,
            'details_ru' => $request->details_ru,
            'details_en' => $request->details_en,
            'date' => $request->date,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $filmCompany = $film->filmCompanies()->findOrFail($companyId);

        DB::beginTransaction();
        try {
            $filmCompany->delete();

            $this->sortCompanies($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveCompanyToFirst(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $filmCompanies = $film->filmCompanies;

        foreach ($filmCompanies as $i => $filmCompany) {
            if ($filmCompany->isIdEqualTo($companyId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($filmCompanies[$j - 1])) {
                        break(1);
                    }

                    $prev = $filmCompanies[$j - 1];
                    $filmCompanies[$j - 1] = $filmCompanies[$j];
                    $filmCompanies[$j] = $prev;
                }
                $film->filmCompanies = $filmCompanies;

                DB::beginTransaction();
                try {
                    $this->sortCompanies($film);
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
    public function moveCompanyUp(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $filmCompanies = $film->filmCompanies;

        foreach ($filmCompanies as $i => $filmCompany) {
            if ($filmCompany->isIdEqualTo($companyId)) {
                if (!isset($filmCompanies[$i - 1])) {
                    $count = count($filmCompanies);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $filmCompanies[$j - 1];
                        $filmCompanies[$j - 1] = $filmCompanies[$j];
                        $filmCompanies[$j] = $next;
                    }
                } else {
                    $previous = $filmCompanies[$i - 1];
                    $filmCompanies[$i - 1] = $filmCompany;
                    $filmCompanies[$i] = $previous;
                }
                $film->filmCompanies = $filmCompanies;

                DB::beginTransaction();
                try {
                    $this->sortCompanies($film);
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
    public function moveCompanyDown(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $filmCompanies = $film->filmCompanies;

        foreach ($filmCompanies as $i => $filmCompany) {
            if ($filmCompany->isIdEqualTo($companyId)) {
                if (!isset($filmCompanies[$i + 1])) {
                    $last = $filmCompanies->last();
                    $count = count($filmCompanies);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $filmCompanies[$j] = $filmCompanies[$j - 1];
                    }

                    $filmCompanies[$j] = $last;
                } else {
                    $next = $filmCompanies[$i + 1];
                    $filmCompanies[$i + 1] = $filmCompany;
                    $filmCompanies[$i] = $next;
                }
                $film->filmCompanies = $filmCompanies;

                DB::beginTransaction();
                try {
                    $this->sortCompanies($film);
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
    public function moveCompanyToLast(int $id, int $companyId): void
    {
        $film = Film::findOrFail($id);
        $filmCompanies = $film->filmCompanies;

        foreach ($filmCompanies as $i => $filmCompany) {
            if ($filmCompany->isIdEqualTo($companyId)) {
                $count = count($filmCompanies);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($filmCompanies[$j + 1])) {
                        break(1);
                    }

                    $next = $filmCompanies[$j + 1];
                    $filmCompanies[$j + 1] = $filmCompanies[$j];
                    $filmCompanies[$j] = $next;
                }
                $film->filmCompanies = $filmCompanies;

                DB::beginTransaction();
                try {
                    $this->sortCompanies($film);
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
    private function sortCompanies(Film $film): void
    {
        foreach ($film->filmCompanies as $i => $filmCompany) {
            $filmCompany->setSort($i + 1);
            $filmCompany->saveOrFail();
        }
    }
}
