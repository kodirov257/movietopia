<?php

namespace App\Services\Manage\Celebrity;

use App\Http\Requests\Admin\Celebrity\Trademarks\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Trademarks\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Trademark;
use Illuminate\Support\Facades\DB;

class TrademarkService
{
    /**
     * @throws \Throwable
     */
    public function addTrademark(int $id, CreateRequest $request): Trademark
    {
        $celebrity = Celebrity::findOrFail($id);

        DB::beginTransaction();
        try {
            $trademark = $celebrity->trademarks()->create([
                'trademark_uz' => $request->trademark_uz,
                'trademark_uz_cy' => $request->trademark_uz_cy,
                'trademark_ru' => $request->trademark_ru,
                'trademark_en' => $request->trademark_en,
            ]);

            $this->sortTrademarks($celebrity);

            DB::commit();

            return $trademark;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateTrademark(int $id, int $trademarkId, UpdateRequest $request): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trademark = $celebrity->trademarks()->findOrFail($trademarkId);

        $trademark->update([
            'trademark_uz' => $request->trademark_uz,
            'trademark_uz_cy' => $request->trademark_uz_cy,
            'trademark_ru' => $request->trademark_ru,
            'trademark_en' => $request->trademark_en,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function removeTrademark(int $id, int $trademarkId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trademark = $celebrity->trademarks()->findOrFail($trademarkId);

        DB::beginTransaction();
        try {
            $trademark->delete();

            $this->sortTrademarks($celebrity);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveTrademarkToFirst(int $id, int $trademarkId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trademarks = $celebrity->trademarks;

        foreach ($trademarks as $i => $trademark) {
            if ($trademark->isIdEqualTo($trademarkId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($trademarks[$j - 1])) {
                        break(1);
                    }

                    $prev = $trademarks[$j - 1];
                    $trademarks[$j - 1] = $trademarks[$j];
                    $trademarks[$j] = $prev;
                }
                $celebrity->trademarks = $trademarks;

                DB::beginTransaction();
                try {
                    $this->sortTrademarks($celebrity);
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
    public function moveTrademarkUp(int $id, int $trademarkId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trademarks = $celebrity->trademarks;

        foreach ($trademarks as $i => $trademark) {
            if ($trademark->isIdEqualTo($trademarkId)) {
                if (!isset($trademarks[$i - 1])) {
                    $count = count($trademarks);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $trademarks[$j - 1];
                        $trademarks[$j - 1] = $trademarks[$j];
                        $trademarks[$j] = $next;
                    }
                } else {
                    $previous = $trademarks[$i - 1];
                    $trademarks[$i - 1] = $trademark;
                    $trademarks[$i] = $previous;
                }
                $celebrity->trademarks = $trademarks;

                DB::beginTransaction();
                try {
                    $this->sortTrademarks($celebrity);
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
    public function moveTrademarkDown(int $id, int $trademarkId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trademarks = $celebrity->trademarks;

        foreach ($trademarks as $i => $trademark) {
            if ($trademark->isIdEqualTo($trademarkId)) {
                if (!isset($trademarks[$i + 1])) {
                    $last = $trademarks->last();
                    $count = count($trademarks);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $trademarks[$j] = $trademarks[$j - 1];
                    }

                    $trademarks[$j] = $last;
                } else {
                    $next = $trademarks[$i + 1];
                    $trademarks[$i + 1] = $trademark;
                    $trademarks[$i] = $next;
                }
                $celebrity->trademarks = $trademarks;

                DB::beginTransaction();
                try {
                    $this->sortTrademarks($celebrity);
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
    public function moveTrademarkToLast(int $id, int $trademarkId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $trademarks = $celebrity->trademarks;

        foreach ($trademarks as $i => $trademark) {
            if ($trademark->isIdEqualTo($trademarkId)) {
                $count = count($trademarks);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($trademarks[$j + 1])) {
                        break(1);
                    }

                    $next = $trademarks[$j + 1];
                    $trademarks[$j + 1] = $trademarks[$j];
                    $trademarks[$j] = $next;
                }
                $celebrity->trademarks = $trademarks;

                DB::beginTransaction();
                try {
                    $this->sortTrademarks($celebrity);
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
    private function sortTrademarks(Celebrity $celebrity): void
    {
        foreach ($celebrity->trademarks as $i => $trademark) {
            $trademark->setSort($i + 1);
            $trademark->saveOrFail();
        }
    }
}
