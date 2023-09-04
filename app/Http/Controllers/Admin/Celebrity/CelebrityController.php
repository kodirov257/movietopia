<?php

namespace App\Http\Controllers\Admin\Celebrity;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Celebrity\Celebrities\BiographyRequest;
use App\Http\Requests\Admin\Celebrity\Celebrities\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Celebrities\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\CountryRegion;
use App\Services\Manage\Celebrity\CelebrityService;
use App\Services\Manage\CountryRegionService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CelebrityController extends Controller
{
    private CelebrityService $service;

    public function __construct(CelebrityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Celebrity::with(['livePlace', 'birthPlace', 'deathPlace'])->orderByDesc('updated_at');

        if (!empty($value = $request->get('full_name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->whereRaw("CONCAT_WS(' ', first_name_uz, last_name_uz) ILIKE '%{$value}%'")
                    ->orWhereRaw("CONCAT_WS(' ', first_name_uz_cy, last_name_uz_cy) ILIKE '%{$value}%'")
                    ->orWhereRaw("CONCAT_WS(' ', first_name_ru, last_name_ru) ILIKE '%{$value}%'")
                    ->orWhereRaw("CONCAT_WS(' ', first_name_en, last_name_en) ILIKE '%{$value}%'");
            });
        }

        if (!empty($value = $request->get('country_id'))) {
            $country = CountryRegion::findOrFail($value);
            $countries = [];
            CountryRegionService::getDescendantIds($country, $countries);
            $query->where(function (Builder $query) use ($countries) {
                $query->whereIn('live_place', $countries)
                    ->orWhereIn('birth_place', $countries);
            });
        }

        $celebrities = $query->paginate(20)
            ->appends('name', $request->get('name'))
            ->appends('country_id', $request->get('country_id'));

        $defaultLivePlace = CountryRegion::orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix())
            ->get()->pluck('place', 'id')->toArray();

        return view('admin.celebrity.celebrities.index', compact('celebrities', 'defaultLivePlace'));
    }

    public function create(): View
    {
        return view('admin.celebrity.celebrities.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        try {
            $celebrity = $this->service->create($request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Celebrity $celebrity): View
    {
        return view('admin.celebrity.celebrities.show', compact('celebrity'));
    }

    public function edit(Celebrity $celebrity): View
    {
        $defaultLivePlace = $celebrity->livePlace()->get()->pluck('place', 'id')->toArray();
        $defaultBirthPlace = $celebrity->birthPlace()->get()->pluck('place', 'id')->toArray();
        $defaultDeathPlace = $celebrity->deathPlace()->get()->pluck('place', 'id')->toArray();

        return view('admin.celebrity.celebrities.edit', compact('celebrity', 'defaultLivePlace', 'defaultBirthPlace', 'defaultDeathPlace'));
    }

    public function update(UpdateRequest $request, Celebrity $celebrity): RedirectResponse
    {
        try {
            $this->service->update($celebrity->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editBiography(BiographyRequest $request, Celebrity $celebrity): View
    {
        return view('admin.celebrity.biography.edit', compact('celebrity'));
    }

    public function updateBiography(BiographyRequest $request, Celebrity $celebrity): RedirectResponse
    {
        $this->service->updateBiography($celebrity->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.celebrities.show', $celebrity);
    }

    public function destroy(Celebrity $celebrity): RedirectResponse
    {
        if ($celebrity->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.celebrities.index');
        }

        try {
            $celebrity->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function removePhoto(Celebrity $celebrity): JsonResponse
    {
        if ($this->service->removePhoto($celebrity->id)) {
            return response()->json('The avatar is successfully deleted!');
        }
        return response()->json('The avatar is not deleted!', 400);
    }
}
