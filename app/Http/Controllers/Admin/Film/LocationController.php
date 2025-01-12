<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Locations\CreateRequest;
use App\Http\Requests\Admin\Film\Locations\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmLocation;
use App\Services\Manage\Film\LocationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function __construct(private readonly LocationService $service)
    {
    }

    public function create(Film $film): View
    {
        return view('admin.film.locations.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $location = $this->service->addLocation($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.locations.show', $location);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmLocation $location): View
    {
        return view('admin.film.locations.show', compact('film', 'location'));
    }

    public function edit(Film $film, FilmLocation $location): View
    {
        return view('admin.film.locations.edit', compact('film', 'location'));
    }

    public function update(UpdateRequest $request, Film $film, FilmLocation $location): RedirectResponse
    {
        try {
            $this->service->updateLocation($film->id, $location->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.locations.show', ['film' => $film, 'location' => $location]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmLocation $location): RedirectResponse
    {
        if ($location->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $location->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmLocation $location) {

        try {
            $this->service->moveLocationToFirst($film->id, $location->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmLocation $location) {

        try {
            $this->service->moveLocationUp($film->id, $location->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmLocation $location) {

        try {
            $this->service->moveLocationDown($film->id, $location->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmLocation $location) {

        try {
            $this->service->moveLocationToLast($film->id, $location->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
