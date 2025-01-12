<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Connections\CreateRequest;
use App\Http\Requests\Admin\Film\Connections\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmConnection;
use App\Services\Manage\Film\ConnectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConnectionController extends Controller
{
    public function __construct(private readonly ConnectionService $service)
    {
    }

    public function create(Film $film): View
    {
        return view('admin.film.connections.create', compact('film'));
    }

    public function store(CreateRequest $request, Film $film): RedirectResponse
    {
        try {
            $connection = $this->service->addConnection($film->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.connections.show', $connection);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film, FilmConnection $connection): View
    {
        return view('admin.film.connections.show', compact('film', 'connection'));
    }

    public function edit(Film $film, FilmConnection $connection): View
    {
        return view('admin.film.connections.edit', compact('film', 'connection'));
    }

    public function update(UpdateRequest $request, Film $film, FilmConnection $connection): RedirectResponse
    {
        try {
            $this->service->updateConnection($film->id, $connection->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.connections.show', ['film' => $film, 'connection' => $connection]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Film $film, FilmConnection $connection): RedirectResponse
    {
        if ($connection->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.show', $film);
        }

        try {
            $this->service->remove($film->id, $connection->id);

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Film $film, FilmConnection $connection) {

        try {
            $this->service->moveConnectionToFirst($film->id, $connection->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Film $film, FilmConnection $connection) {

        try {
            $this->service->moveConnectionUp($film->id, $connection->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Film $film, FilmConnection $connection) {

        try {
            $this->service->moveConnectionDown($film->id, $connection->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Film $film, FilmConnection $connection) {

        try {
            $this->service->moveConnectionToLast($film->id, $connection->id);
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
