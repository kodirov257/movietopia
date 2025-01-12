<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Slogans\CreateRequest;
use App\Http\Requests\Admin\Film\Slogans\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmSlogan;
use Illuminate\Support\Facades\DB;

class SloganService
{
    /**
     * @throws \Throwable
     */
    public function addSlogan(int $id, CreateRequest $request): FilmSlogan
    {
        $film = Film::findOrFail($id);

        DB::beginTransaction();
        try {
            $slogan = $film->slogans()->create([
                'slogan_uz' => $request->slogan_uz,
                'slogan_uz_cy' => $request->slogan_uz_cy,
                'slogan_ru' => $request->slogan_ru,
                'slogan_en' => $request->slogan_en,
                'main' => $request->main,
            ]);

            $this->sortSlogans($film);

            DB::commit();

            return $slogan;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSlogan(int $id, int $sloganId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $slogan = $film->slogans()->findOrFail($sloganId);

        $slogan->update([
            'slogan_uz' => $request->slogan_uz,
            'slogan_uz_cy' => $request->slogan_uz_cy,
            'slogan_ru' => $request->slogan_ru,
            'slogan_en' => $request->slogan_en,
            'main' => $request->main,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $sloganId): void
    {
        $film = Film::findOrFail($id);
        $slogan = $film->slogans()->findOrFail($sloganId);

        DB::beginTransaction();
        try {
            $slogan->delete();

            $this->sortSlogans($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveSloganToFirst(int $id, int $sloganId): void
    {
        $film = Film::findOrFail($id);
        $slogans = $film->slogans;

        foreach ($slogans as $i => $slogan) {
            if ($slogan->isIdEqualTo($sloganId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($slogans[$j - 1])) {
                        break(1);
                    }

                    $prev = $slogans[$j - 1];
                    $slogans[$j - 1] = $slogans[$j];
                    $slogans[$j] = $prev;
                }
                $film->slogans = $slogans;

                DB::beginTransaction();
                try {
                    $this->sortSlogans($film);
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
    public function moveSloganUp(int $id, int $sloganId): void
    {
        $film = Film::findOrFail($id);
        $slogans = $film->slogans;

        foreach ($slogans as $i => $slogan) {
            if ($slogan->isIdEqualTo($sloganId)) {
                if (!isset($slogans[$i - 1])) {
                    $count = count($slogans);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $slogans[$j - 1];
                        $slogans[$j - 1] = $slogans[$j];
                        $slogans[$j] = $next;
                    }
                } else {
                    $previous = $slogans[$i - 1];
                    $slogans[$i - 1] = $slogan;
                    $slogans[$i] = $previous;
                }
                $film->slogans = $slogans;

                DB::beginTransaction();
                try {
                    $this->sortSlogans($film);
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
    public function moveSloganDown(int $id, int $sloganId): void
    {
        $film = Film::findOrFail($id);
        $slogans = $film->slogans;

        foreach ($slogans as $i => $slogan) {
            if ($slogan->isIdEqualTo($sloganId)) {
                if (!isset($slogans[$i + 1])) {
                    $last = $slogans->last();
                    $count = count($slogans);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $slogans[$j] = $slogans[$j - 1];
                    }

                    $slogans[$j] = $last;
                } else {
                    $next = $slogans[$i + 1];
                    $slogans[$i + 1] = $slogan;
                    $slogans[$i] = $next;
                }
                $film->slogans = $slogans;

                DB::beginTransaction();
                try {
                    $this->sortSlogans($film);
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
    public function moveSloganToLast(int $id, int $sloganId): void
    {
        $film = Film::findOrFail($id);
        $slogans = $film->slogans;

        foreach ($slogans as $i => $slogan) {
            if ($slogan->isIdEqualTo($sloganId)) {
                $count = count($slogans);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($slogans[$j + 1])) {
                        break(1);
                    }

                    $next = $slogans[$j + 1];
                    $slogans[$j + 1] = $slogans[$j];
                    $slogans[$j] = $next;
                }
                $film->slogans = $slogans;

                DB::beginTransaction();
                try {
                    $this->sortSlogans($film);
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
    private function sortSlogans(Film $film): void
    {
        foreach ($film->slogans as $i => $slogan) {
            $slogan->setSort($i + 1);
            $slogan->saveOrFail();
        }
    }
}
