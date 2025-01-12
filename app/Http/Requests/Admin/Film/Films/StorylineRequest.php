<?php

namespace App\Http\Requests\Admin\Film\Films;

use App\Models\Celebrity\Celebrity;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $storyline_uz
 * @property string $storyline_uz_cy
 * @property string $storyline_ru
 * @property string $storyline_en
 */
class StorylineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'storyline_uz' => 'required|string',
            'storyline_uz_cy' => 'nullable|string',
            'storyline_ru' => 'required|string',
            'storyline_en' => 'required|string',
        ];
    }
}
