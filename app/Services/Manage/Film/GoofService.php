<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Goofs\CreateRequest;
use App\Http\Requests\Admin\Film\Goofs\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmGoof;
use Illuminate\Support\Facades\DB;

class GoofService
{
    /**
     * @throws \Throwable
     */
    public function addGoof(int $id, CreateRequest $request): FilmGoof
    {
        $film = Film::findOrFail($id);

        DB::beginTransaction();
        try {
            $goof = $film->goofs()->create([
                'goof_uz' => $request->goof_uz,
                'goof_uz_cy' => $request->goof_uz_cy,
                'goof_ru' => $request->goof_ru,
                'goof_en' => $request->goof_en,
                'type_id' => $request->type_id,
                'spoiler' => $request->spoiler,
            ]);

            $this->sortGoofs($film);

            DB::commit();

            return $goof;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateGoof(int $id, int $goofId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $goof = $film->goofs()->findOrFail($goofId);

        $goof->update([
            'goof_uz' => $request->goof_uz,
            'goof_uz_cy' => $request->goof_uz_cy,
            'goof_ru' => $request->goof_ru,
            'goof_en' => $request->goof_en,
            'type_id' => $request->type_id,
            'spoiler' => $request->spoiler,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $goofId): void
    {
        $film = Film::findOrFail($id);
        $goof = $film->goofs()->findOrFail($goofId);

        DB::beginTransaction();
        try {
            $goof->delete();

            $this->sortGoofs($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveToFirst(int $id, int $goofId): void
    {
        $film = Film::findOrFail($id);
        $goofs = $film->goofs;

        foreach ($goofs as $i => $goof) {
            if ($goof->isIdEqualTo($goofId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($goofs[$j - 1])) {
                        break(1);
                    }

                    $prev = $goofs[$j - 1];
                    $goofs[$j - 1] = $goofs[$j];
                    $goofs[$j] = $prev;
                }
                $film->goofs = $goofs;

                DB::beginTransaction();
                try {
                    $this->sortGoofs($film);
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
    public function moveUp(int $id, int $goofId): void
    {
        $film = Film::findOrFail($id);
        $goofs = $film->goofs;

        foreach ($goofs as $i => $goof) {
            if ($goof->isIdEqualTo($goofId)) {
                if (!isset($goofs[$i - 1])) {
                    $count = count($goofs);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $goofs[$j - 1];
                        $goofs[$j - 1] = $goofs[$j];
                        $goofs[$j] = $next;
                    }
                } else {
                    $previous = $goofs[$i - 1];
                    $goofs[$i - 1] = $goof;
                    $goofs[$i] = $previous;
                }
                $film->goofs = $goofs;

                DB::beginTransaction();
                try {
                    $this->sortGoofs($film);
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
    public function moveDown(int $id, int $goofId): void
    {
        $film = Film::findOrFail($id);
        $goofs = $film->goofs;

        foreach ($goofs as $i => $goof) {
            if ($goof->isIdEqualTo($goofId)) {
                if (!isset($goofs[$i + 1])) {
                    $last = $goofs->last();
                    $count = count($goofs);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $goofs[$j] = $goofs[$j - 1];
                    }

                    $goofs[$j] = $last;
                } else {
                    $next = $goofs[$i + 1];
                    $goofs[$i + 1] = $goof;
                    $goofs[$i] = $next;
                }
                $film->goofs = $goofs;

                DB::beginTransaction();
                try {
                    $this->sortGoofs($film);
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
    public function moveToLast(int $id, int $goofId): void
    {
        $film = Film::findOrFail($id);
        $goofs = $film->goofs;

        foreach ($goofs as $i => $goof) {
            if ($goof->isIdEqualTo($goofId)) {
                $count = count($goofs);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($goofs[$j + 1])) {
                        break(1);
                    }

                    $next = $goofs[$j + 1];
                    $goofs[$j + 1] = $goofs[$j];
                    $goofs[$j] = $next;
                }
                $film->goofs = $goofs;

                DB::beginTransaction();
                try {
                    $this->sortGoofs($film);
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
    private function sortGoofs(Film $film): void
    {
        foreach ($film->goofs as $i => $goof) {
            $goof->setSort($i + 1);
            $goof->saveOrFail();
        }
    }
}
