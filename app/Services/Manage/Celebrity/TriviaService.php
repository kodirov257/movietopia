<?php

namespace App\Services\Manage\Celebrity;

use App\Http\Requests\Admin\Celebrity\Trivias\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Trivias\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Trivia;
use Illuminate\Support\Facades\DB;

class TriviaService
{
    /**
     * @throws \Throwable
     */
    public function addTrivia(int $id, CreateRequest $request): Trivia
    {
        $celebrity = Celebrity::findOrFail($id);

        DB::beginTransaction();
        try {
            $trivia = $celebrity->trivia()->create([
                'trivia_uz' => $request->trivia_uz,
                'trivia_uz_cy' => $request->trivia_uz_cy,
                'trivia_ru' => $request->trivia_ru,
                'trivia_en' => $request->trivia_en,
            ]);

            $this->sortTrivias($celebrity);

            DB::commit();

            return $trivia;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateTrivia(int $id, int $triviaId, UpdateRequest $request): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trivia = $celebrity->trivia()->findOrFail($triviaId);

        $trivia->update([
            'trivia_uz' => $request->trivia_uz,
            'trivia_uz_cy' => $request->trivia_uz_cy,
            'trivia_ru' => $request->trivia_ru,
            'trivia_en' => $request->trivia_en,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function removeTrivia(int $id, int $triviaId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trivia = $celebrity->trivia()->findOrFail($triviaId);

        DB::beginTransaction();
        try {
            $trivia->delete();

            $this->sortTrivias($celebrity);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveTriviaToFirst(int $id, int $triviaId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trivias = $celebrity->trivia;

        foreach ($trivias as $i => $trivia) {
            if ($trivia->isIdEqualTo($triviaId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($trivias[$j - 1])) {
                        break(1);
                    }

                    $prev = $trivias[$j - 1];
                    $trivias[$j - 1] = $trivias[$j];
                    $trivias[$j] = $prev;
                }
                $celebrity->trivia = $trivias;

                DB::beginTransaction();
                try {
                    $this->sortTrivias($celebrity);
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
    public function moveTriviaUp(int $id, int $triviaId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trivias = $celebrity->trivia;

        foreach ($trivias as $i => $trivia) {
            if ($trivia->isIdEqualTo($triviaId)) {
                if (!isset($trivias[$i - 1])) {
                    $count = count($trivias);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $trivias[$j - 1];
                        $trivias[$j - 1] = $trivias[$j];
                        $trivias[$j] = $next;
                    }
                } else {
                    $previous = $trivias[$i - 1];
                    $trivias[$i - 1] = $trivia;
                    $trivias[$i] = $previous;
                }
                $celebrity->trivia = $trivias;

                DB::beginTransaction();
                try {
                    $this->sortTrivias($celebrity);
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
    public function moveTriviaDown(int $id, int $triviaId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trivias = $celebrity->trivia;

        foreach ($trivias as $i => $trivia) {
            if ($trivia->isIdEqualTo($triviaId)) {
                if (!isset($trivias[$i + 1])) {
                    $last = $trivias->last();
                    $count = count($trivias);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $trivias[$j] = $trivias[$j - 1];
                    }

                    $trivias[$j] = $last;
                } else {
                    $next = $trivias[$i + 1];
                    $trivias[$i + 1] = $trivia;
                    $trivias[$i] = $next;
                }
                $celebrity->trivia = $trivias;

                DB::beginTransaction();
                try {
                    $this->sortTrivias($celebrity);
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
    public function moveTriviaToLast(int $id, int $triviaId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trivias = $celebrity->trivia;

        foreach ($trivias as $i => $trivia) {
            if ($trivia->isIdEqualTo($triviaId)) {
                $count = count($trivias);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($trivias[$j + 1])) {
                        break(1);
                    }

                    $next = $trivias[$j + 1];
                    $trivias[$j + 1] = $trivias[$j];
                    $trivias[$j] = $next;
                }
                $celebrity->trivia = $trivias;

                DB::beginTransaction();
                try {
                    $this->sortTrivias($celebrity);
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
    private function sortTrivias(Celebrity $celebrity): void
    {
        foreach ($celebrity->trivia as $i => $trivia) {
            $trivia->setSort($i + 1);
            $trivia->saveOrFail();
        }
    }
}
