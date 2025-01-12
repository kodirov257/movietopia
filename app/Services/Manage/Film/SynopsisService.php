<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Synopses\CreateRequest;
use App\Http\Requests\Admin\Film\Synopses\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmSynopsis;
use Illuminate\Support\Facades\DB;

class SynopsisService
{
    /**
     * @throws \Throwable
     */
    public function addSynopsis(int $id, CreateRequest $request): FilmSynopsis
    {
        $film = Film::findOrFail($id);

        DB::beginTransaction();
        try {
            $synopsis = $film->synopses()->create([
                'synopsis_uz' => $request->synopsis_uz,
                'synopsis_uz_cy' => $request->synopsis_uz_cy,
                'synopsis_ru' => $request->synopsis_ru,
                'synopsis_en' => $request->synopsis_en,
                'type' => $request->type,
            ]);

            $this->sortSynopses($film);

            DB::commit();

            return $synopsis;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSynopsis(int $id, int $synopsisId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $synopsis = $film->synopses()->findOrFail($synopsisId);

        $synopsis->update([
            'synopsis_uz' => $request->synopsis_uz,
            'synopsis_uz_cy' => $request->synopsis_uz_cy,
            'synopsis_ru' => $request->synopsis_ru,
            'synopsis_en' => $request->synopsis_en,
            'type' => $request->type,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $synopsisId): void
    {
        $film = Film::findOrFail($id);
        $synopsis = $film->synopses()->findOrFail($synopsisId);

        DB::beginTransaction();
        try {
            $synopsis->delete();

            $this->sortSynopses($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveSynopsisToFirst(int $id, int $synopsisId): void
    {
        $film = Film::findOrFail($id);
        $synopses = $film->synopses;

        foreach ($synopses as $i => $synopsis) {
            if ($synopsis->isIdEqualTo($synopsisId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($synopses[$j - 1])) {
                        break(1);
                    }

                    $prev = $synopses[$j - 1];
                    $synopses[$j - 1] = $synopses[$j];
                    $synopses[$j] = $prev;
                }
                $film->synopses = $synopses;

                DB::beginTransaction();
                try {
                    $this->sortSynopses($film);
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
    public function moveSynopsisUp(int $id, int $synopsisId): void
    {
        $film = Film::findOrFail($id);
        $synopses = $film->synopses;

        foreach ($synopses as $i => $synopsis) {
            if ($synopsis->isIdEqualTo($synopsisId)) {
                if (!isset($synopses[$i - 1])) {
                    $count = count($synopses);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $synopses[$j - 1];
                        $synopses[$j - 1] = $synopses[$j];
                        $synopses[$j] = $next;
                    }
                } else {
                    $previous = $synopses[$i - 1];
                    $synopses[$i - 1] = $synopsis;
                    $synopses[$i] = $previous;
                }
                $film->synopses = $synopses;

                DB::beginTransaction();
                try {
                    $this->sortSynopses($film);
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
    public function moveSynopsisDown(int $id, int $synopsisId): void
    {
        $film = Film::findOrFail($id);
        $synopses = $film->synopses;

        foreach ($synopses as $i => $synopsis) {
            if ($synopsis->isIdEqualTo($synopsisId)) {
                if (!isset($synopses[$i + 1])) {
                    $last = $synopses->last();
                    $count = count($synopses);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $synopses[$j] = $synopses[$j - 1];
                    }

                    $synopses[$j] = $last;
                } else {
                    $next = $synopses[$i + 1];
                    $synopses[$i + 1] = $synopsis;
                    $synopses[$i] = $next;
                }
                $film->synopses = $synopses;

                DB::beginTransaction();
                try {
                    $this->sortSynopses($film);
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
    public function moveSynopsisToLast(int $id, int $synopsisId): void
    {
        $film = Film::findOrFail($id);
        $synopses = $film->synopses;

        foreach ($synopses as $i => $synopsis) {
            if ($synopsis->isIdEqualTo($synopsisId)) {
                $count = count($synopses);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($synopses[$j + 1])) {
                        break(1);
                    }

                    $next = $synopses[$j + 1];
                    $synopses[$j + 1] = $synopses[$j];
                    $synopses[$j] = $next;
                }
                $film->synopses = $synopses;

                DB::beginTransaction();
                try {
                    $this->sortSynopses($film);
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
    private function sortSynopses(Film $film): void
    {
        foreach ($film->synopses as $i => $synopsis) {
            $synopsis->setSort($i + 1);
            $synopsis->saveOrFail();
        }
    }
}
