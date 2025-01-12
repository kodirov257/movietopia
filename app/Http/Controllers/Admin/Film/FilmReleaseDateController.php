<?php

namespace App\Http\Controllers\Admin\Film;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\FilmReleaseDates\CreateRequest;
use App\Http\Requests\Admin\Film\FilmReleaseDates\UpdateRequest;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmCompany;
use App\Models\Film\FilmReleaseDate;
use App\Services\Manage\Film\FilmReleaseDateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FilmReleaseDateController extends Controller
{
    public function __construct(private readonly FilmReleaseDateService $service)
    {
    }

    public function create(Film $film): View
    {
        $name = 'name_' . LanguageHelper::getCurrentLanguagePrefix();
        $countries = CountryRegion::orderBy($name)->pluck($name, 'id');
        return view('admin.film.film-release-dates.create', compact('film', 'countries'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $releaseDate = $this->service->add($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.release-dates.show', [
                'film' => $film->id,
                'release_date' => $releaseDate,
            ]);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmReleaseDate $releaseDate): View
    {
        return view('admin.film.film-release-dates.show', compact('film', 'releaseDate'));
    }

    public function edit(Film $film, FilmReleaseDate $releaseDate): View
    {
        $name = 'name_' . LanguageHelper::getCurrentLanguagePrefix();
        $countries = CountryRegion::orderBy($name)->pluck($name, 'id');
        return view('admin.film.film-release-dates.edit', compact('film', 'releaseDate', 'countries'));
    }

    public function update(UpdateRequest $request, Film $film, FilmReleaseDate $releaseDate): RedirectResponse
    {
        try {
            $this->service->update($film->id, $releaseDate->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.release-dates.show', [
                'film' => $film->id,
                'release_date' => $releaseDate,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmReleaseDate $releaseDate): RedirectResponse
    {
        if ($releaseDate->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', [
                'film' => $film,
            ]);
        }

        try {
            $this->service->remove($film->id, $releaseDate->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', [
                'film' => $film,
            ]);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmCompany $company, FilmReleaseDate $releaseDate): RedirectResponse
    {

        try {
            $this->service->moveReleaseDateToFirst($company->id, $releaseDate->id);
            return redirect()->route('dashboard.films.companies.show', [
                'film' => $film,
                'company' => $company,
            ]);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmCompany $company, FilmReleaseDate $releaseDate): RedirectResponse
    {

        try {
            $this->service->moveReleaseDateUp($company->id, $releaseDate->id);
            return redirect()->route('dashboard.films.companies.show', [
                'film' => $film,
                'company' => $company,
            ]);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmCompany $company, FilmReleaseDate $releaseDate): RedirectResponse
    {
        try {
            $this->service->moveReleaseDateDown($company->id, $releaseDate->id);
            return redirect()->route('dashboard.films.companies.show', [
                'film' => $film,
                'company' => $company,
            ]);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmCompany $company, FilmReleaseDate $releaseDate): RedirectResponse
    {

        try {
            $this->service->moveReleaseDateToLast($company->id, $releaseDate->id);
            return redirect()->route('dashboard.films.companies.show', [
                'film' => $film,
                'company' => $company,
            ]);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
