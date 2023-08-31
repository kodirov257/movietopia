<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Countries\CreateRequest;
use App\Http\Requests\Admin\Countries\UpdateRequest;
use App\Models\Country;
use App\Services\Manage\CountryService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CountryController extends Controller
{
    private CountryService $service;

    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Country::orderByDesc('updated_at');

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $countries = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.countries.index', compact('countries'));
    }

    public function create(): View
    {
        return view('admin.countries.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $country = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.countries.show', $country);
    }

    public function show(Country $country): View
    {
        return view('admin.countries.show', compact('country'));
    }

    public function edit(Country $country): View
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(UpdateRequest $request, Country $country): RedirectResponse
    {
        $this->service->update($country->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.countries.show', $country);
    }

    public function destroy(Country $country): RedirectResponse
    {
        if ($country->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.countries.index');
        }

        try {
            $country->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.countries.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
