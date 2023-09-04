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
        $company = $this->service->create($celebrity->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.celebrities.trademarks.show', $company);
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
        $this->service->update($celebrity->id, $trademark->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.celebrities.trademarks.show', ['celebrity' => $celebrity, 'trademark' => $trademark]);
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
}
