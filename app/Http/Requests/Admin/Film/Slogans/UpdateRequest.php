<?php

namespace App\Http\Requests\Admin\Film\Slogans;

use App\Models\Film\FilmSlogan;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $slogan_uz
 * @property string $slogan_uz_cy
 * @property string $slogan_ru
 * @property string $slogan_en
 * @property bool $main
 *
 * @property FilmSlogan $film_slogan
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
            'slogan_uz' => 'required|string',
            'slogan_uz_cy' => 'nullable|string',
            'slogan_ru' => 'required|string',
            'slogan_en' => 'required|string',
            'main' => 'nullable|bool',
        ];
    }
}
