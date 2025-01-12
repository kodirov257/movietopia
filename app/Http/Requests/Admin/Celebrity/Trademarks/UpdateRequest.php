<?php

namespace App\Http\Requests\Admin\Celebrity\Trademarks;

use App\Models\Celebrity\Trademark;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $trademark_uz
 * @property string $trademark_uz_cy
 * @property string $trademark_ru
 * @property string $trademark_en
 *
 * @property Trademark $trademark
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
            'trademark_uz' => 'required|string',
            'trademark_uz_cy' => 'nullable|string',
            'trademark_ru' => 'required|string',
            'trademark_en' => 'required|string',
        ];
    }
}
