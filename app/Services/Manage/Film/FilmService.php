<?php

namespace App\Services\Manage\Film;

use App\Entity\Meta;
use App\Helpers\ImageHelper;
use App\Http\Requests\Admin\Film\Films\CreateRequest;
use App\Http\Requests\Admin\Film\Films\DescriptionRequest;
use App\Http\Requests\Admin\Film\Films\StorylineRequest;
use App\Http\Requests\Admin\Film\Films\UpdateRequest;
use App\Models\Film\Film;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmService
{
    private ?int $nextId = null;

    /**
     * @throws \Throwable
     */
    public function create(CreateRequest $request): Film
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        DB::beginTransaction();
        try {
            $film = Film::make([
                'title_uz' => strip_tags(htmlspecialchars($request->title_uz)),
                'title_uz_cy' => $request->title_uz_cy ? strip_tags(htmlspecialchars($request->title_uz_cy)) : null,
                'title_ru' => strip_tags(htmlspecialchars($request->title_ru)),
                'title_en' => strip_tags(htmlspecialchars($request->title_en)),
                'original_title' => strip_tags(htmlspecialchars($request->original_title)),
                'description_uz' => '',
                'description_uz_cy' => '',
                'description_ru' => '',
                'description_en' => '',
                'slug' => $request->slug,
                'tv_series' => $request->tv_series,
                'status' => $request->status,
                'poster' => $request->poster,
                'age_rating' => $request->age_rating,
                'duration_minutes' => $request->duration_minutes,
                'world_released_at' => $request->world_released_at,
                'budget_estimated' => $request->budget_estimated,
                'budget_from' => $request->budget_from,
                'budget_to' => $request->budget_to,
                'box_office_local' => $request->box_office_local,
                'box_office_worldwide' => $request->box_office_worldwide,
                'filming_date_from' => $request->filming_date_from,
                'filming_date_to' => $request->filming_date_to,
                'sites' => $request->sites,
                'imdb_rating' => $request->imdb_rating,
                'imdb_rating_votes' => $request->imdb_rating_votes,
                'meta_json' => $meta,
            ]);

            if (!$request->tv_series) {
                $film->last_season_released_at = $request->last_season_released_at;
                $film->last_episode_released_at = $request->last_episode_released_at;
            }

            $imageName = null;
            if ($request->poster) {
                $imageName = ImageHelper::getRandomName($request->poster);
                $film->id = $this->getNextId();
                $film->poster = $imageName;
            }

            $film->save();

            if ($request->poster) {
                $this->uploadPhoto($film->id, $request->poster, $imageName);
            }

            $this->addGenres($film, $request->genres);
            $this->addTypes($film, $request->types);

            DB::commit();

            return $film;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function update(int $id, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        if ($request->poster) {
            Storage::disk('public')->deleteDirectory('/files/' . ImageHelper::FOLDER_FILMS . '/' . $film->id);
            $imageName = ImageHelper::getRandomName($request->poster);
            $film->poster = $imageName;
        }

        try {
            $film->update([
                'title_uz' => strip_tags(htmlspecialchars($request->title_uz)),
                'title_uz_cy' => $request->title_uz_cy ? strip_tags(htmlspecialchars($request->title_uz_cy)) : null,
                'title_ru' => strip_tags(htmlspecialchars($request->title_ru)),
                'title_en' => strip_tags(htmlspecialchars($request->title_en)),
                'original_title' => strip_tags(htmlspecialchars($request->original_title)),
                'slug' => $request->slug,
                'tv_series' => $request->tv_series,
                'status' => $request->status,
                'poster' => $request->poster,
                'age_rating' => $request->age_rating,
                'duration_minutes' => $request->duration_minutes,
                'world_released_at' => $request->world_released_at,
                'budget_estimated' => $request->budget_estimated,
                'budget_from' => $request->budget_from,
                'budget_to' => $request->budget_to,
                'box_office_local' => $request->box_office_local,
                'box_office_worldwide' => $request->box_office_worldwide,
                'filming_date_from' => $request->filming_date_from,
                'filming_date_to' => $request->filming_date_to,
                'sites' => $request->sites,
                'imdb_rating' => $request->imdb_rating,
                'imdb_rating_votes' => $request->imdb_rating_votes,
                'meta_json' => $meta,
            ]);

            $film->filmGenres()->delete();
            $this->addGenres($film, $request->genres);

            $film->filmTypes()->delete();
            $this->addTypes($film, $request->types);

            DB::commit();

            if (isset($imageName)) {
                $this->uploadPhoto($film->id, $request->poster, $film->poster);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateDescription(int $id, DescriptionRequest $request): void
    {
        $film = Film::findOrFail($id);

        $film->update([
            'description_uz' => htmlspecialchars($request->description_uz),
            'description_uz_cy' => $request->description_uz_cy ? htmlspecialchars($request->description_uz_cy) : null,
            'description_ru' => htmlspecialchars($request->description_ru),
            'description_en' => htmlspecialchars($request->description_en),
        ]);
    }

    public function updateStoryline(int $id, StorylineRequest $request): void
    {
        $film = Film::findOrFail($id);

        $film->update([
            'storyline_uz' => htmlspecialchars($request->storyline_uz),
            'storyline_uz_cy' => $request->storyline_uz_cy ? htmlspecialchars($request->storyline_uz_cy) : null,
            'storyline_ru' => htmlspecialchars($request->storyline_ru),
            'storyline_en' => htmlspecialchars($request->storyline_en),
        ]);
    }

    public function addGenres(Film $film, array $genres = null): void
    {
        if ($genres) {
            $genres = array_unique($genres);
            foreach ($genres as $genreId) {
                $film->filmGenres()->create(['genre_id' => $genreId]);
            }
        }
    }

    public function addTypes(Film $film, array $types = null): void
    {
        if ($types) {
            $types = array_unique($types);
            foreach ($types as $typeId) {
                $film->filmTypes()->create(['type_id' => $typeId]);
            }
        }
    }

    public function getNextId(): int
    {
        if (!$this->nextId) {
            $nextId = DB::select("select nextval('film_films_id_seq')");
            return $this->nextId = (int)$nextId['0']->nextval;
        }
        return $this->nextId;
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id): bool
    {
        $film = Film::findOrFail($id);
        DB::beginTransaction();
        try {
            $film->slogans()->delete();
            $film->synopses()->delete();
            $film->trivias()->delete();
            $film->goofs()->delete();
            $film->credits()->delete();
            $film->filmConnections()->delete();
            $film->titles()->delete();
            $film->filmCountries()->delete();
            $film->filmLanguages()->delete();
            $film->filmLocations()->delete();
            $film->filmCompanies()->delete();
            $film->releaseDates()->delete();
            $film->filmGenres()->delete();
            $film->filmTypes()->delete();
            $film->alternateVersions()->delete();

            if ($film->poster) {
                $this->deletePoster($film->id);
            }

            $film->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function removePoster(int $id): bool
    {
        $film = Film::findOrFail($id);

        return $this->deletePoster($id) && $film->update(['poster' => null]);
    }

    public function deletePoster(int $id): bool
    {
        return Storage::disk('public')->deleteDirectory('/files/' . ImageHelper::FOLDER_FILMS . '/' . $id);
    }

    private function uploadPhoto(int $filmId, UploadedFile $photo, string $imageName): void
    {
        ImageHelper::saveThumbnail($filmId, ImageHelper::FOLDER_FILMS, $photo, $imageName);
        ImageHelper::saveCustom($filmId, ImageHelper::FOLDER_FILMS, $photo, $imageName, 128, 96);
        ImageHelper::saveOriginal($filmId, ImageHelper::FOLDER_FILMS, $photo, $imageName);
    }
}
