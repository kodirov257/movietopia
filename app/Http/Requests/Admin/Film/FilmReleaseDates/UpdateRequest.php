<?php

namespace App\Http\Requests\Admin\Film\FilmReleaseDates;

use App\Models\Film\FilmReleaseDate;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $country_id
 * @property string $details_uz
 * @property string $details_uz_cy
 * @property string $details_ru
 * @property string $details_en
 * @property Carbon $release_date
 *
 * @property FilmReleaseDate $film_release_date
 */
class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|int|exists:countries_regions,id',
            'details_uz' => 'nullable|string',
            'details_uz_cy' => 'nullable|string',
            'details_ru' => 'nullable|string',
            'details_en' => 'nullable|string',
            'release_date' => 'required|date',
        ];
    }
}
