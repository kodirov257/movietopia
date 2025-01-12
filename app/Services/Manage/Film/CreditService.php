<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Credits\CreateRequest;
use App\Http\Requests\Admin\Film\Credits\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmCredit;
use Illuminate\Support\Facades\DB;

class CreditService
{
    /**
     * @throws \Throwable
     */
    public function addCredit(int $id, CreateRequest $request): FilmCredit
    {
        $film = Film::findOrFail($id);

        DB::beginTransaction();
        try {
            $credit = $film->credits()->create([
                'credit_uz' => $request->credit_uz,
                'credit_uz_cy' => $request->credit_uz_cy,
                'credit_ru' => $request->credit_ru,
                'credit_en' => $request->credit_en,
            ]);

            $this->sortCredits($film);

            DB::commit();

            return $credit;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateCredit(int $id, int $creditId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $credit = $film->credits()->findOrFail($creditId);

        $credit->update([
            'credit_uz' => $request->credit_uz,
            'credit_uz_cy' => $request->credit_uz_cy,
            'credit_ru' => $request->credit_ru,
            'credit_en' => $request->credit_en,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $creditId): void
    {
        $film = Film::findOrFail($id);
        $credit = $film->goofs()->findOrFail($creditId);

        DB::beginTransaction();
        try {
            $credit->delete();

            $this->sortCredits($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveToFirst(int $id, int $creditId): void
    {
        $film = Film::findOrFail($id);
        $credits = $film->credits;

        foreach ($credits as $i => $credit) {
            if ($credit->isIdEqualTo($creditId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($credits[$j - 1])) {
                        break(1);
                    }

                    $prev = $credits[$j - 1];
                    $credits[$j - 1] = $credits[$j];
                    $credits[$j] = $prev;
                }
                $film->credits = $credits;

                DB::beginTransaction();
                try {
                    $this->sortCredits($film);
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
    public function moveUp(int $id, int $creditId): void
    {
        $film = Film::findOrFail($id);
        $credits = $film->credits;

        foreach ($credits as $i => $credit) {
            if ($credit->isIdEqualTo($creditId)) {
                if (!isset($credits[$i - 1])) {
                    $count = count($credits);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $credits[$j - 1];
                        $credits[$j - 1] = $credits[$j];
                        $credits[$j] = $next;
                    }
                } else {
                    $previous = $credits[$i - 1];
                    $credits[$i - 1] = $credit;
                    $credits[$i] = $previous;
                }
                $film->credits = $credits;

                DB::beginTransaction();
                try {
                    $this->sortCredits($film);
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
    public function moveDown(int $id, int $creditId): void
    {
        $film = Film::findOrFail($id);
        $credits = $film->credits;

        foreach ($credits as $i => $credit) {
            if ($credit->isIdEqualTo($creditId)) {
                if (!isset($credits[$i + 1])) {
                    $last = $credits->last();
                    $count = count($credits);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $credits[$j] = $credits[$j - 1];
                    }

                    $credits[$j] = $last;
                } else {
                    $next = $credits[$i + 1];
                    $credits[$i + 1] = $credit;
                    $credits[$i] = $next;
                }
                $film->credits = $credits;

                DB::beginTransaction();
                try {
                    $this->sortCredits($film);
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
    public function moveToLast(int $id, int $creditId): void
    {
        $film = Film::findOrFail($id);
        $credits = $film->credits;

        foreach ($credits as $i => $credit) {
            if ($credit->isIdEqualTo($creditId)) {
                $count = count($credits);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($credits[$j + 1])) {
                        break(1);
                    }

                    $next = $credits[$j + 1];
                    $credits[$j + 1] = $credits[$j];
                    $credits[$j] = $next;
                }
                $film->credits = $credits;

                DB::beginTransaction();
                try {
                    $this->sortCredits($film);
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
    private function sortCredits(Film $film): void
    {
        foreach ($film->credits as $i => $credit) {
            $credit->setSort($i + 1);
            $credit->saveOrFail();
        }
    }
}
