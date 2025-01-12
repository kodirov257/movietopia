<?php

namespace App\Http\Controllers\Admin\Film;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Goofs\CreateRequest;
use App\Http\Requests\Admin\Film\Goofs\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmGoof;
use App\Models\Film\GoofType;
use App\Services\Manage\Film\GoofService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GoofController extends Controller
{
    private GoofService $service;

    public function __construct(GoofService $service)
    {
        $this->service = $service;
    }

    public function create(Film $film): View
    {
        $types = GoofType::orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix(), 'id');
        return view('admin.film.goofs.create', compact('film', 'types'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $goof = $this->service->addGoof($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.goofs.show', $goof);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmGoof $goof): View
    {
        return view('admin.film.goofs.show', compact('film', 'goof'));
    }

    public function edit(Film $film, FilmGoof $goof): View
    {
        $types = GoofType::orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix(), 'id');
        return view('admin.film.goofs.edit', compact('film', 'goof', 'types'));
    }

    public function update(UpdateRequest $request, Film $film, FilmGoof $goof): RedirectResponse
    {
        try {
            $this->service->updateGoof($film->id, $goof->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.goofs.show', ['film' => $film, 'goof' => $goof]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmGoof $goof): RedirectResponse
    {
        if ($goof->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $goof->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmGoof $goof) {

        try {
            $this->service->moveToFirst($film->id, $goof->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmGoof $goof) {

        try {
            $this->service->moveUp($film->id, $goof->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmGoof $goof) {

        try {
            $this->service->moveDown($film->id, $goof->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmGoof $goof) {

        try {
            $this->service->moveToLast($film->id, $goof->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
