<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Credits\CreateRequest;
use App\Http\Requests\Admin\Film\Credits\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmCredit;
use App\Services\Manage\Film\CreditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CreditController extends Controller
{
    public function __construct(private readonly CreditService $service)
    {
    }

    public function create(Film $film): View
    {
        return view('admin.film.credits.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $credit = $this->service->addCredit($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.credits.show', $credit);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmCredit $credit): View
    {
        return view('admin.film.credits.show', compact('film', 'credit'));
    }

    public function edit(Film $film, FilmCredit $credit): View
    {
        return view('admin.film.credits.edit', compact('film', 'credit'));
    }

    public function update(UpdateRequest $request, Film $film, FilmCredit $credit): RedirectResponse
    {
        try {
            $this->service->updateCredit($film->id, $credit->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.credits.show', ['film' => $film, 'credit' => $credit]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmCredit $credit): RedirectResponse
    {
        if ($credit->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $credit->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmCredit $credit) {

        try {
            $this->service->moveToFirst($film->id, $credit->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmCredit $credit) {

        try {
            $this->service->moveUp($film->id, $credit->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmCredit $credit) {

        try {
            $this->service->moveDown($film->id, $credit->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmCredit $credit) {

        try {
            $this->service->moveToLast($film->id, $credit->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
