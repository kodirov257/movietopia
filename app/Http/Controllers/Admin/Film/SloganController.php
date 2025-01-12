<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Slogans\CreateRequest;
use App\Http\Requests\Admin\Film\Slogans\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmSlogan;
use App\Services\Manage\Film\SloganService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SloganController extends Controller
{
    private SloganService $service;

    public function __construct(SloganService $service)
    {
        $this->service = $service;
    }

    public function create(Film $film): View
    {
        return view('admin.film.slogans.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $slogan = $this->service->addSlogan($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.slogans.show', $slogan);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmSlogan $slogan): View
    {
        return view('admin.film.slogans.show', compact('film', 'slogan'));
    }

    public function edit(Film $film, FilmSlogan $slogan): View
    {
        return view('admin.film.slogans.edit', compact('film', 'slogan'));
    }

    public function update(UpdateRequest $request, Film $film, FilmSlogan $slogan): RedirectResponse
    {
        try {
            $this->service->updateSlogan($film->id, $slogan->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.slogans.show', ['film' => $film, 'slogan' => $slogan]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmSlogan $slogan): RedirectResponse
    {
        if ($slogan->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $slogan->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmSlogan $slogan) {

        try {
            $this->service->moveSloganToFirst($film->id, $slogan->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmSlogan $slogan) {

        try {
            $this->service->moveSloganUp($film->id, $slogan->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmSlogan $slogan) {

        try {
            $this->service->moveSloganDown($film->id, $slogan->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmSlogan $slogan) {

        try {
            $this->service->moveSloganToLast($film->id, $slogan->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
