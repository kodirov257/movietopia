<?php

namespace App\Http\Controllers\Admin\Celebrity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Celebrity\Quotes\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Quotes\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Quote;
use App\Services\Manage\Celebrity\QuoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuoteController extends Controller
{
    private QuoteService $service;

    public function __construct(QuoteService $service)
    {
        $this->service = $service;
    }

    public function create(Celebrity $celebrity): View
    {
        return view('admin.celebrity.quotes.create', compact('celebrity'));
    }

    public function store(CreateRequest $request, Celebrity $celebrity): RedirectResponse
    {
        try {
            $quote = $this->service->addQuote($celebrity->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.quotes.show', $quote);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Celebrity $celebrity, Quote $quote): View
    {
        return view('admin.celebrity.quotes.show', compact('celebrity', 'quote'));
    }

    public function edit(Celebrity $celebrity, Quote $quote): View
    {
        return view('admin.celebrity.quotes.edit', compact('celebrity', 'quote'));
    }

    public function update(UpdateRequest $request, Celebrity $celebrity, Quote $quote): RedirectResponse
    {
        try {
            $this->service->updateQuote($celebrity->id, $quote->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.quotes.show', ['celebrity' => $celebrity, 'quote' => $quote]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Celebrity $celebrity, Quote $quote): RedirectResponse
    {
        if ($quote->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        }

        try {
            $quote->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Celebrity $celebrity, Quote $quote) {

        try {
            $this->service->moveQuoteToFirst($celebrity->id, $quote->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Celebrity $celebrity, Quote $quote) {

        try {
            $this->service->moveQuoteUp($celebrity->id, $quote->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Celebrity $celebrity, Quote $quote) {

        try {
            $this->service->moveQuoteDown($celebrity->id, $quote->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Celebrity $celebrity, Quote $quote) {

        try {
            $this->service->moveQuoteToLast($celebrity->id, $quote->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
