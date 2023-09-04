<?php

namespace App\Http\Controllers\Admin\Celebrity;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Celebrity\Relatives\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Relatives\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\CelebrityRelative;
use App\Services\Manage\Celebrity\CelebrityRelativeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CelebrityRelativeController extends Controller
{
    private CelebrityRelativeService $service;

    public function __construct(CelebrityRelativeService $service)
    {
        $this->service = $service;
    }

    public function create(Celebrity $celebrity): View
    {
        return view('admin.celebrity.relatives.create', compact('celebrity'));
    }

    public function store(CreateRequest $request, Celebrity $celebrity): RedirectResponse
    {
        try {
            $relative = $this->service->addRelative($celebrity->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.relatives.show', ['celebrity' => $celebrity, 'relative' => $relative]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Celebrity $celebrity, CelebrityRelative $relative): View
    {
        return view('admin.celebrity.relatives.show', compact('celebrity', 'relative'));
    }

    public function edit(Celebrity $celebrity, CelebrityRelative $relative): View
    {
        if ($relative->relative_id) {
            $defaultRelative = $relative->relative()->get()->pluck('full_name', 'id')->toArray();
        } else {
            $defaultRelative = $relative->get()->pluck('full_name', 'id')->toArray();
        }
        return view('admin.celebrity.relatives.edit', compact('celebrity', 'relative', 'defaultRelative'));
    }

    public function update(UpdateRequest $request, Celebrity $celebrity, CelebrityRelative $relative): RedirectResponse
    {
        try {
            $this->service->updateRelative($celebrity->id, $relative->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.relatives.show', ['celebrity' => $celebrity, 'relative' => $relative]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Celebrity $celebrity, CelebrityRelative $relative): RedirectResponse
    {
        if ($relative->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        }

        try {
            $relative->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
