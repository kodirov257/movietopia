<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\AlternateVersions\CreateRequest;
use App\Http\Requests\Admin\Film\AlternateVersions\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmAlternateVersion;
use App\Services\Manage\Film\AlternateVersionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AlternateVersionController extends Controller
{

    public function __construct(private readonly AlternateVersionService $service)
    {
    }

    public function create(Film $film): View
    {
        return view('admin.film.alternate-versions.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $alternateVersion = $this->service->add($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.alternate-versions.show', $alternateVersion);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmAlternateVersion $alternateVersion): View
    {
        return view('admin.film.alternate-versions.show', compact('film', 'alternateVersion'));
    }

    public function edit(Film $film, FilmAlternateVersion $alternateVersion): View
    {
        return view('admin.film.alternate-versions.edit', compact('film', 'alternateVersion'));
    }

    public function update(UpdateRequest $request, Film $film, FilmAlternateVersion $alternateVersion): RedirectResponse
    {
        try {
            $this->service->update($film->id, $alternateVersion->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.alternate-versions.show', ['film' => $film, 'alternateVersion' => $alternateVersion]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmAlternateVersion $alternateVersion): RedirectResponse
    {
        if ($alternateVersion->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $alternateVersion->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmAlternateVersion $alternateVersion) {

        try {
            $this->service->moveAlternateVersionToFirst($film->id, $alternateVersion->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmAlternateVersion $alternateVersion) {

        try {
            $this->service->moveAlternateVersionUp($film->id, $alternateVersion->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmAlternateVersion $alternateVersion) {

        try {
            $this->service->moveAlternateVersionDown($film->id, $alternateVersion->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmAlternateVersion $alternateVersion) {

        try {
            $this->service->moveAlternateVersionToLast($film->id, $alternateVersion->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
