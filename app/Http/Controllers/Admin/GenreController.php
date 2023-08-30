<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Genres\CreateRequest;
use App\Http\Requests\Genres\UpdateRequest;
use App\Models\Genre;
use App\Services\Manage\GenreService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GenreController extends Controller
{
    private GenreService $service;

    public function __construct(GenreService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Genre::orderByDesc('updated_at');

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $genres = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.genres.index', compact('genres'));
    }

    public function create(): View
    {
        return view('admin.genres.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $genre = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.genres.show', $genre);
    }

    public function show(Genre $genre): View
    {
        return view('admin.genres.show', compact('genre'));
    }

    public function edit(Genre $genre): View
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(UpdateRequest $request, Genre $genre): RedirectResponse
    {
        $this->service->update($genre->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.genres.show', $genre);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        if ($genre->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.genres.index');
        }

        try {
            $genre->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.genres.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
