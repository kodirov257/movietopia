<?php

namespace App\Http\Controllers\Admin\Celebrity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Celebrity\Trademarks\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Trademarks\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Trademark;
use App\Services\Manage\Celebrity\TrademarkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TrademarkController extends Controller
{
    private TrademarkService $service;

    public function __construct(TrademarkService $service)
    {
        $this->service = $service;
    }

    public function create(Celebrity $celebrity): View
    {
        return view('admin.celebrity.trademarks.create', compact('celebrity'));
    }

    public function store(CreateRequest $request, Celebrity $celebrity): RedirectResponse
    {
        try {
            $company = $this->service->addTrademark($celebrity->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.trademarks.show', $company);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Celebrity $celebrity, Trademark $trademark): View
    {
        return view('admin.celebrity.trademarks.show', compact('celebrity', 'trademark'));
    }

    public function edit(Celebrity $celebrity, Trademark $trademark): View
    {
        return view('admin.celebrity.trademarks.edit', compact('celebrity', 'trademark'));
    }

    public function update(UpdateRequest $request, Celebrity $celebrity, Trademark $trademark): RedirectResponse
    {
        try {
            $this->service->updateTrademark($celebrity->id, $trademark->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.trademarks.show', ['celebrity' => $celebrity, 'trademark' => $trademark]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Celebrity $celebrity, Trademark $trademark): RedirectResponse
    {
        if ($trademark->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        }

        try {
            $trademark->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Celebrity $celebrity, Trademark $trademark) {

        try {
            $this->service->moveTrademarkToFirst($celebrity->id, $trademark->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Celebrity $celebrity, Trademark $trademark) {

        try {
            $this->service->moveTrademarkUp($celebrity->id, $trademark->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Celebrity $celebrity, Trademark $trademark) {

        try {
            $this->service->moveTrademarkDown($celebrity->id, $trademark->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Celebrity $celebrity, Trademark $trademark) {

        try {
            $this->service->moveTrademarkToLast($celebrity->id, $trademark->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
