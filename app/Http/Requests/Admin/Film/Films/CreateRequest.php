<?php

namespace App\Http\Requests\Admin\Film\Films;

use App\Models\Film\Film;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * @property string $title_uz
 * @property string $title_uz_cy
 * @property string $title_ru
 * @property string $title_en
 * @property string $original_title
 * @property string $slug
 * @property int[] $genres
 * @property int[] $types
 * @property bool $tv_series
 * @property int $status
 * @property UploadedFile $poster
 * @property int $age_rating
 * @property int $duration_minutes
 * @property int $world_released_at
 * @property Carbon $last_season_released_at
 * @property Carbon $last_episode_released_at
 * @property bool $budget_estimated
 * @property int $budget_from
 * @property int $budget_to
 * @property int $box_office_local
 * @property int $box_office_worldwide
 * @property Carbon $filming_date_from
 * @property Carbon $filming_date_to
 * @property string[] $sites
 * @property float $imdb_rating
 * @property int $imdb_rating_votes
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 */
class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_uz' => 'required|string|max:255',
            'title_uz_cy' => 'nullable|string|max:255',
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'original_title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:film_films',
            'genres' => 'required|array|min:1',
            'genres.*' => 'required|int|max:1|exists:genres,id',
            'types' => 'nullable|array|min:1',
            'types.*' => 'required|int|max:1|exists:types,id',
            'tv_series' => 'nullable|bool',
            'status' => ['required', 'int', Rule::in(array_keys(Film::statusesList()))],
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'age_rating' => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:0',
            'world_released_at' => 'required|integer',
            'last_season_released_at' => 'required_with_all:tv_series|nullable|date_format:Y-m-d',
            'last_episode_released_at' => 'required_with_all:tv_series|nullable|date_format:Y-m-d',
            'budget_estimated' => 'nullable|bool',
            'budget_from' => 'nullable|integer|min:0',
            'budget_to' => 'nullable|integer|min:0',
            'box_office_local' => 'nullable|integer|min:0',
            'box_office_worldwide' => 'nullable|integer|min:0',
            'filming_date_from' => 'nullable|date_format:Y-m-d',
            'filming_date_to' => 'nullable|date_format:Y-m-d',
            'sites' => 'nullable|array',
            'sites.*' => 'required_with_all:sites|string|url',
            'imdb_rating' => 'nullable|numeric|min:0',
            'imdb_rating_votes' => 'nullable|integer|min:0',
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_keywords' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
        ];
    }
}
