<?php

namespace App\Http\Requests\Admin\Film\Goofs;

use App\Models\Film\FilmGoof;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $goof_uz
 * @property string $goof_uz_cy
 * @property string $goof_ru
 * @property string $goof_en
 * @property int $type_id
 * @property bool $spoiler
 *
 * @property FilmGoof $film_goof
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
            'goof_uz' => 'required|string',
            'goof_uz_cy' => 'nullable|string',
            'goof_ru' => 'required|string',
            'goof_en' => 'required|string',
            'type_id' => 'required|int|max:1|exists:film_goof_types,id',
            'spoiler' => 'nullable|bool',
        ];
    }
}
