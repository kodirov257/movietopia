<?php

namespace App\Http\Requests\Admin\Celebrity\Quotes;

use App\Models\Celebrity\Quote;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $quote_uz
 * @property string $quote_uz_cy
 * @property string $quote_ru
 * @property string $quote_en
 *
 * @property Quote $quote
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
            'quote_uz' => 'required|string',
            'quote_uz_cy' => 'nullable|string',
            'quote_ru' => 'required|string',
            'quote_en' => 'required|string',
        ];
    }
}
