<?php

namespace App\Http\Requests\Admin\Film\Films;

use App\Models\Celebrity\Celebrity;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $description_uz
 * @property string $description_uz_cy
 * @property string $description_ru
 * @property string $description_en
 */
class DescriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description_uz' => 'required|string',
            'description_uz_cy' => 'nullable|string',
            'description_ru' => 'required|string',
            'description_en' => 'required|string',
        ];
    }
}
