<?php

namespace App\Http\Requests\Admin\Film\Slogans;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $slogan_uz
 * @property string $slogan_uz_cy
 * @property string $slogan_ru
 * @property string $slogan_en
 * @property bool $main
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
            'slogan_uz' => 'required|string',
            'slogan_uz_cy' => 'nullable|string',
            'slogan_ru' => 'required|string',
            'slogan_en' => 'required|string',
            'main' => 'nullable|bool',
        ];
    }
}
