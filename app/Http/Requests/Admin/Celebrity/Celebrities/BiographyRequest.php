<?php

namespace App\Http\Requests\Admin\Celebrity\Celebrities;

use App\Models\Celebrity\Celebrity;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $biography_uz
 * @property string $biography_uz_cy
 * @property string $biography_ru
 * @property string $biography_en
 */
class BiographyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'biography_uz' => 'nullable|string',
            'biography_uz_cy' => 'nullable|string',
            'biography_ru' => 'nullable|string',
            'biography_en' => 'nullable|string',
        ];
    }
}
