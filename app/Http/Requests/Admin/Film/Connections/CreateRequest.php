<?php

namespace App\Http\Requests\Admin\Film\Connections;

use App\Models\Film\FilmConnection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $connected_film_id
 * @property string $connection_uz
 * @property string $connection_uz_cy
 * @property string $connection_ru
 * @property string $connection_en
 * @property string $type
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
            'connected_film_id' => 'required|int|exists:film_films,id',
            'connection_uz' => 'required|string',
            'connection_uz_cy' => 'nullable|string',
            'connection_ru' => 'required|string',
            'connection_en' => 'required|string',
            'type' => ['required', 'string', Rule::in(array_keys(FilmConnection::typesList()))],
        ];
    }
}
