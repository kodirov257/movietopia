<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRegions\CreateRequest;
use App\Http\Requests\Admin\CountryRegions\UpdateRequest;
use App\Models\CountryRegion;
use App\Services\Manage\CountryRegionService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CountryRegionController extends Controller
{
    private CountryRegionService $service;

    public function __construct(CountryRegionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = CountryRegion::with('parent')->orderByDesc('updated_at')
            ->countries('type', CountryRegion::COUNTRY);

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $countries = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.country-regions.index', compact('countries'));
    }

    public function create(Request $request): View
    {
        $parent = null;

        if ($request->get('parent')) {
            $parent = CountryRegion::findOrFail($request->get('parent'));
        }

        return view('admin.country-regions.create', compact('parent'));
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $country = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.country-regions.show', $country);
    }

    public function show(CountryRegion $countryRegion): View
    {
        return view('admin.country-regions.show', compact('countryRegion'));
    }

    public function edit(CountryRegion $countryRegion): View
    {
        return view('admin.country-regions.edit', compact('countryRegion'));
    }

    public function update(UpdateRequest $request, CountryRegion $countryRegion): RedirectResponse
    {
        $this->service->update($countryRegion->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.country-regions.show', $countryRegion);
    }

    public function destroy(CountryRegion $countryRegion): RedirectResponse
    {
        $parentId = $countryRegion->parent_id;
        if ($countryRegion->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            if ($parentId) {
                return redirect()->route('dashboard.country-regions.show', $parentId);
            }

            return redirect()->route('dashboard.country-regions.index');
        }

        try {
            $countryRegion->delete();

            session()->flash('message', 'запись обновлён ');

            if ($parentId) {
                return redirect()->route('dashboard.country-regions.show', $parentId);
            }

            return redirect()->route('dashboard.country-regions.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
