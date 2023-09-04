<?php

namespace App\Services\Manage\Celebrity;

use App\Http\Requests\Admin\Celebrity\Quotes\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Quotes\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Quote;
use Illuminate\Support\Facades\DB;

class QuoteService
{
    /**
     * @throws \Throwable
     */
    public function addQuote(int $id, CreateRequest $request): Quote
    {
        $celebrity = Celebrity::findOrFail($id);

        DB::beginTransaction();
        try {
            $quote = $celebrity->quotes()->create([
                'quote_uz' => $request->quote_uz,
                'quote_uz_cy' => $request->quote_uz_cy,
                'quote_ru' => $request->quote_ru,
                'quote_en' => $request->quote_en,
            ]);

            $this->sortQuotes($celebrity);

            DB::commit();

            return $quote;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateQuote(int $id, int $quoteId, UpdateRequest $request): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $quote = $celebrity->quotes()->findOrFail($quoteId);

        $quote->update([
            'quote_uz' => $request->quote_uz,
            'quote_uz_cy' => $request->quote_uz_cy,
            'quote_ru' => $request->quote_ru,
            'quote_en' => $request->quote_en,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function removeQuote(int $id, int $quoteId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $quote = $celebrity->quotes()->findOrFail($quoteId);

        DB::beginTransaction();
        try {
            $quote->delete();

            $this->sortQuotes($celebrity);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveQuoteToFirst(int $id, int $quoteId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $quotes = $celebrity->quotes;

        foreach ($quotes as $i => $quote) {
            if ($quote->isIdEqualTo($quoteId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($quotes[$j - 1])) {
                        break(1);
                    }

                    $prev = $quotes[$j - 1];
                    $quotes[$j - 1] = $quotes[$j];
                    $quotes[$j] = $prev;
                }
                $celebrity->quotes = $quotes;

                DB::beginTransaction();
                try {
                    $this->sortQuotes($celebrity);
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
    public function moveQuoteUp(int $id, int $quoteId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $quotes = $celebrity->quotes;

        foreach ($quotes as $i => $quote) {
            if ($quote->isIdEqualTo($quoteId)) {
                if (!isset($quotes[$i - 1])) {
                    $count = count($quotes);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $quotes[$j - 1];
                        $quotes[$j - 1] = $quotes[$j];
                        $quotes[$j] = $next;
                    }
                } else {
                    $previous = $quotes[$i - 1];
                    $quotes[$i - 1] = $quote;
                    $quotes[$i] = $previous;
                }
                $celebrity->quotes = $quotes;

                DB::beginTransaction();
                try {
                    $this->sortQuotes($celebrity);
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
    public function moveQuoteDown(int $id, int $quoteId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $quotes = $celebrity->quotes;

        foreach ($quotes as $i => $quote) {
            if ($quote->isIdEqualTo($quoteId)) {
                if (!isset($quotes[$i + 1])) {
                    $last = $quotes->last();
                    $count = count($quotes);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $quotes[$j] = $quotes[$j - 1];
                    }

                    $quotes[$j] = $last;
                } else {
                    $next = $quotes[$i + 1];
                    $quotes[$i + 1] = $quote;
                    $quotes[$i] = $next;
                }
                $celebrity->quotes = $quotes;

                DB::beginTransaction();
                try {
                    $this->sortQuotes($celebrity);
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
    public function moveQuoteToLast(int $id, int $quoteId): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $quotes = $celebrity->quotes;

        foreach ($quotes as $i => $quote) {
            if ($quote->isIdEqualTo($quoteId)) {
                $count = count($quotes);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($quotes[$j + 1])) {
                        break(1);
                    }

                    $next = $quotes[$j + 1];
                    $quotes[$j + 1] = $quotes[$j];
                    $quotes[$j] = $next;
                }
                $celebrity->quotes = $quotes;

                DB::beginTransaction();
                try {
                    $this->sortQuotes($celebrity);
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
    private function sortQuotes(Celebrity $celebrity): void
    {
        foreach ($celebrity->quotes as $i => $quote) {
            $quote->setSort($i + 1);
            $quote->saveOrFail();
        }
    }
}
