<?php

namespace App\Http\Requests\Admin\Celebrity\Quotes;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $quote_uz
 * @property string $quote_uz_cy
 * @property string $quote_ru
 * @property string $quote_en
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
            'quote_uz' => 'required|string',
            'quote_uz_cy' => 'nullable|string',
            'quote_ru' => 'required|string',
            'quote_en' => 'required|string',
        ];
    }
}
