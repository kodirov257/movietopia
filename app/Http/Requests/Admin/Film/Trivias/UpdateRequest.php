<?php

namespace App\Http\Requests\Admin\Film\Trivias;

use App\Models\Film\FilmTrivia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $trivia_uz
 * @property string $trivia_uz_cy
 * @property string $trivia_ru
 * @property string $trivia_en
 * @property string $type
 * @property bool $spoiler
 *
 * @property FilmTrivia $film_trivia
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
            'trivia_uz' => 'required|string',
            'trivia_uz_cy' => 'nullable|string',
            'trivia_ru' => 'required|string',
            'trivia_en' => 'required|string',
            'type' => ['required', 'string', Rule::in(array_keys(FilmTrivia::typesList()))],
            'spoiler' => 'nullable|bool',
        ];
    }
}
