<?php

namespace App\Http\Controllers\Admin\Film;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\Films\CreateRequest;
use App\Http\Requests\Admin\Film\Films\DescriptionRequest;
use App\Http\Requests\Admin\Film\Films\StorylineRequest;
use App\Http\Requests\Admin\Film\Films\UpdateRequest;
use App\Models\Company;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmCompany;
use App\Models\Film\FilmConnection;
use App\Models\Film\FilmCountry;
use App\Models\Film\FilmGenre;
use App\Models\Film\FilmLanguage;
use App\Models\Film\FilmLocation;
use App\Models\Film\FilmType;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Type;
use App\Services\Manage\Film\FilmService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FilmController extends Controller
{
    private FilmService $service;

    public function __construct(FilmService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Film::with([
            'filmGenres', 'filmCompanies', 'filmCountries', 'filmConnections', 'filmTypes', 'filmLanguages', 'filmLocations'
        ])->orderByDesc('updated_at');

        if (!empty($value = $request->get('title'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('title_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('title_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('title_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('title_en', 'ilike', '%' . $value . '%');
            });
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('release_date_from'))) {
            $query->whereDate('world_release_date', '>=', $value);
        }

        if (!empty($value = $request->get('release_date_to'))) {
            $query->whereDate('world_release_date', '<=', $value);
        }

        if (!empty($value = $request->get('genre_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmGenre())->getTable())
                    ->where('genre_id', $value);
            });
        }

        if (!empty($value = $request->get('type_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmType())->getTable())
                    ->where('type_id', $value);
            });
        }

        if (!empty($value = $request->get('company_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmCompany())->getTable())
                    ->where('company_id', $value);
            });
        }

        if (!empty($value = $request->get('country_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmCountry())->getTable())
                    ->where('country_id', $value);
            });
        }

        if (!empty($value = $request->get('connection_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmConnection())->getTable())
                    ->where('connection_id', $value);
            });
        }

        if (!empty($value = $request->get('type_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmType())->getTable())
                    ->where('type_id', $value);
            });
        }

        if (!empty($value = $request->get('language_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmLanguage())->getTable())
                    ->where('language_id', $value);
            });
        }

        if (!empty($value = $request->get('location_id'))) {
            $query->whereIn('id', function (Builder $query) use ($value) {
                $query->select('film_id')
                    ->from(with(new FilmLocation())->getTable())
                    ->where('location_id', $value);
            });
        }

        $films = $query->paginate(20)
            ->appends('title', $request->get('title'))
            ->appends('status', $request->get('status'))
            ->appends('genre_id', $request->get('genre_id'))
            ->appends('type_id', $request->get('type_id'))
            ->appends('company_id', $request->get('company_id'))
            ->appends('country_id', $request->get('country_id'))
            ->appends('connection_id', $request->get('connection_id'))
            ->appends('type_id', $request->get('type_id'))
            ->appends('language_id', $request->get('language_id'))
            ->appends('location_id', $request->get('location_id'))
            ->appends('release_date_from', $request->get('release_date_from'))
            ->appends('release_date_to', $request->get('release_date_to'));

        $name = 'name_' . LanguageHelper::getCurrentLanguagePrefix();
        $genres = Genre::orderBy($name)->pluck($name, 'id')->toArray();

        $companies = Company::orderBy($name)->pluck($name, 'id')->toArray();

        $countries = CountryRegion::where('type', CountryRegion::COUNTRY)
            ->orderBy($name)
            ->pluck($name, 'id')->toArray();

        $types = Type::orderBy($name)->pluck($name, 'id')->toArray();

        $languages = Language::orderBy($name)->pluck($name, 'id')->toArray();

        return view('admin.film.films.index',
            compact('films', 'genres', 'companies', 'countries', 'types', 'languages')
        );
    }

    public function create(): View
    {
        $name = 'name_' . LanguageHelper::getCurrentLanguagePrefix();
        $genres = Genre::all()->pluck($name, 'id');
        $types = Type::orderBy($name)->pluck($name, 'id')->toArray();
        return view('admin.film.films.create', compact('genres', 'types'));
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        try {
            $celebrity = $this->service->create($request);
            session()->flash('message', 'запись обновлён');
            return redirect()->route('dashboard.films.show', $celebrity);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Film $film): View
    {
        return view('admin.film.films.show', compact('film'));
    }

    public function edit(Film $film): View
    {
        $name = 'name_' . LanguageHelper::getCurrentLanguagePrefix();
        $title = 'title_' . LanguageHelper::getCurrentLanguagePrefix();
        $genres = Genre::orderBy($name)->pluck($name, 'id');
        $types = Type::orderBy($name)->pluck($name, 'id')->toArray();
        $defaultCompanies = $film->companies()->pluck($name, 'id')->toArray();
        $countries = CountryRegion::orderBy($name)->pluck($name, 'id');
        $defaultConnections = $film->connectedFilms()->pluck($title, 'id')->toArray();
        $languages = Language::orderBy($name)->pluck($name, 'id')->toArray();
        $defaultLocations = $film->locations()->get()->pluck('place', 'id')->toArray();

        return view('admin.film.films.edit',
            compact('film', 'genres', 'defaultCompanies', 'countries', 'types', 'languages', 'defaultConnections', 'defaultLocations')
        );
    }

    public function update(UpdateRequest $request, Film $film): RedirectResponse
    {
        try {
            $this->service->update($film->id, $request);
            session()->flash('message', 'запись обновлён');
            return redirect()->route('dashboard.films.show', $film);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editDescription(Film $film): View
    {
        return view('admin.film.description.edit', compact('film'));
    }

    public function updateDescription(DescriptionRequest $request, Film $film): RedirectResponse
    {
        $this->service->updateDescription($film->id, $request);
        session()->flash('message', 'запись обновлён');
        return redirect()->route('dashboard.films.show', $film);
    }

    public function editStoryline(Film $film): View
    {
        return view('admin.film.storyline.edit', compact('film'));
    }

    public function updateStoryline(StorylineRequest $request, Film $film): RedirectResponse
    {
        $this->service->updateStoryline($film->id, $request);
        session()->flash('message', 'запись обновлён');
        return redirect()->route('dashboard.films.show', $film);
    }

    public function destroy(Film $film): RedirectResponse
    {
        if ($film->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.films.index');
        }

        try {
            $film->delete();

            session()->flash('message', 'запись обновлён');
            return redirect()->route('dashboard.films.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function removePoster(Film $film): JsonResponse
    {
        if ($this->service->removePoster($film->id)) {
            return response()->json('The avatar is successfully deleted!');
        }
        return response()->json('The avatar is not deleted!', 400);
    }
}
