<?php

namespace App\Http\Controllers\Admin\Film;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Companies\CreateRequest;
use App\Http\Requests\Admin\Film\Companies\UpdateRequest;
use App\Models\Company;
use App\Models\Film\Film;
use App\Models\Film\FilmCompany;
use App\Services\Manage\Film\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $service)
    {
    }

    public function create(Film $film): View
    {
        $companies = Company::orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix())
            ->pluck('name_' . LanguageHelper::getCurrentLanguagePrefix(), 'id')
            ->toArray();;
        return view('admin.film.companies.create', compact('film', 'companies'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $company = $this->service->addCompany($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.companies.show', $company);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmCompany $company): View
    {
        return view('admin.film.companies.show', compact('film', 'company'));
    }

    public function edit(Film $film, FilmCompany $company): View
    {
        $companies = Company::orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix())
            ->pluck('name_' . LanguageHelper::getCurrentLanguagePrefix(), 'id')
            ->toArray();
        return view('admin.film.companies.edit', compact('film', 'company', 'companies'));
    }

    public function update(UpdateRequest $request, Film $film, FilmCompany $company): RedirectResponse
    {
        try {
            $this->service->updateCompany($film->id, $company->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.companies.show', ['film' => $film, 'company' => $company]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmCompany $company): RedirectResponse
    {
        if ($company->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $company->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmCompany $company): RedirectResponse
    {

        try {
            $this->service->moveCompanyToFirst($film->id, $company->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmCompany $company): RedirectResponse
    {

        try {
            $this->service->moveCompanyUp($film->id, $company->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmCompany $company): RedirectResponse
    {
        try {
            $this->service->moveCompanyDown($film->id, $company->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmCompany $company): RedirectResponse
    {

        try {
            $this->service->moveCompanyToLast($film->id, $company->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
