<?php

namespace App\Http\Requests\Admin\Celebrity\Trivias;

use App\Models\Celebrity\Trivia;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $trivia_uz
 * @property string $trivia_uz_cy
 * @property string $trivia_ru
 * @property string $trivia_en
 *
 * @property Trivia $trivia
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
        ];
    }
}
