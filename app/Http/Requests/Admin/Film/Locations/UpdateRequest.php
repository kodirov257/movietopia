<?php

namespace App\Http\Requests\Admin\Film\Locations;

use App\Models\Film\FilmLocation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $location_id
 * @property string $details_uz
 * @property string $details_uz_cy
 * @property string $details_ru
 * @property string $details_en
 *
 * @property FilmLocation $film_location
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
            'location_id' => 'required|int|exists:countries_regions,id',
            'details_uz' => 'required|string',
            'details_uz_cy' => 'nullable|string',
            'details_ru' => 'required|string',
            'details_en' => 'required|string',
        ];
    }
}
