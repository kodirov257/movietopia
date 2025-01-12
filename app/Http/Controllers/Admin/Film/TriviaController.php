<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Trivias\CreateRequest;
use App\Http\Requests\Admin\Film\Trivias\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmTrivia;
use App\Services\Manage\Film\TriviaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TriviaController extends Controller
{
    private TriviaService $service;

    public function __construct(TriviaService $service)
    {
        $this->service = $service;
    }

    public function create(Film $film): View
    {
        return view('admin.film.trivias.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $company = $this->service->addTrivia($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.trivias.show', $company);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmTrivia $trivia): View
    {
        return view('admin.film.trivias.show', compact('film', 'trivia'));
    }

    public function edit(Film $film, FilmTrivia $trivia): View
    {
        return view('admin.film.trivias.edit', compact('film', 'trivia'));
    }

    public function update(UpdateRequest $request, Film $film, FilmTrivia $trivia): RedirectResponse
    {
        try {
            $this->service->updateTrivia($film->id, $trivia->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.trivias.show', ['film' => $film, 'trivia' => $trivia]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmTrivia $trivia): RedirectResponse
    {
        if ($trivia->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $trivia->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmTrivia $trivia) {

        try {
            $this->service->moveTriviaToFirst($film->id, $trivia->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmTrivia $trivia) {

        try {
            $this->service->moveTriviaUp($film->id, $trivia->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmTrivia $trivia) {

        try {
            $this->service->moveTriviaDown($film->id, $trivia->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmTrivia $trivia) {

        try {
            $this->service->moveTriviaToLast($film->id, $trivia->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
