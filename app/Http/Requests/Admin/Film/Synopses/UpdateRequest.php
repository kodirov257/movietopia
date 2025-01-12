<?php

namespace App\Http\Requests\Admin\Film\Synopses;

use App\Models\Film\FilmSynopsis;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $synopsis_uz
 * @property string $synopsis_uz_cy
 * @property string $synopsis_ru
 * @property string $synopsis_en
 * @property string $type
 *
 * @property FilmSynopsis $film_synopsis
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
            'synopsis_uz' => 'required|string',
            'synopsis_uz_cy' => 'nullable|string',
            'synopsis_ru' => 'required|string',
            'synopsis_en' => 'required|string',
            'type' => ['required', 'string', Rule::in(array_keys(FilmSynopsis::typesList()))],
        ];
    }
}
