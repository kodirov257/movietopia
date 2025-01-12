<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Synopses\CreateRequest;
use App\Http\Requests\Admin\Film\Synopses\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmSynopsis;
use App\Services\Manage\Film\SynopsisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SynopsisController extends Controller
{
    private SynopsisService $service;

    public function __construct(SynopsisService $service)
    {
        $this->service = $service;
    }

    public function create(Film $film): View
    {
        return view('admin.film.synopses.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $synopsis = $this->service->addSynopsis($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.synopses.show', $synopsis);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmSynopsis $synopsis): View
    {
        return view('admin.film.synopses.show', compact('film', 'synopsis'));
    }

    public function edit(Film $film, FilmSynopsis $synopsis): View
    {
        return view('admin.film.synopses.edit', compact('film', 'synopsis'));
    }

    public function update(UpdateRequest $request, Film $film, FilmSynopsis $synopsis): RedirectResponse
    {
        try {
            $this->service->updateSynopsis($film->id, $synopsis->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.synopses.show', ['film' => $film, 'synopsis' => $synopsis]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmSynopsis $synopsis): RedirectResponse
    {
        if ($synopsis->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $synopsis->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmSynopsis $synopsis) {

        try {
            $this->service->moveSynopsisToFirst($film->id, $synopsis->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmSynopsis $synopsis) {

        try {
            $this->service->moveSynopsisUp($film->id, $synopsis->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmSynopsis $synopsis) {

        try {
            $this->service->moveSynopsisDown($film->id, $synopsis->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmSynopsis $synopsis) {

        try {
            $this->service->moveSynopsisToLast($film->id, $synopsis->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
