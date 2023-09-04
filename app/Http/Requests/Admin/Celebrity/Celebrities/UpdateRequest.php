<?php

namespace App\Http\Requests\Admin\Celebrity\Celebrities;

use App\Models\Celebrity\Celebrity;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $first_name_uz
 * @property string $first_name_uz_cy
 * @property string $first_name_ru
 * @property string $first_name_en
 * @property string $middle_name_uz
 * @property string $middle_name_uz_cy
 * @property string $middle_name_ru
 * @property string $middle_name_en
 * @property string $last_name_uz
 * @property string $last_name_uz_cy
 * @property string $last_name_ru
 * @property string $last_name_en
 * @property \Illuminate\Http\UploadedFile $photo
 * @property string $professions_uz
 * @property string $professions_uz_cy
 * @property string $professions_ru
 * @property string $professions_en
 * @property string $biography_uz
 * @property string $biography_uz_cy
 * @property string $biography_ru
 * @property string $biography_en
 * @property int $live_place
 * @property string $original_name
 * @property string $birth_name
 * @property string $nicknames
 * @property Carbon $birth_date
 * @property int $birth_place
 * @property Carbon $death_date
 * @property int $death_place
 * @property string $gender
 * @property float $height_foot
 * @property float $height_meter
 * @property string $twitter
 * @property string $facebook
 * @property string $instagram
 * @property string $google_plus
 * @property string $youtube
 * @property string $linkedin
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Celebrity $celebrity
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
            'first_name_uz' => 'required|string|max:255',
            'first_name_uz_cy' => 'nullable|string|max:255',
            'first_name_ru' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'middle_name_uz' => 'nullable|string|max:255',
            'middle_name_uz_cy' => 'nullable|string|max:255',
            'middle_name_ru' => 'nullable|string|max:255',
            'middle_name_en' => 'nullable|string|max:255',
            'last_name_uz' => 'required|string|max:255',
            'last_name_uz_cy' => 'nullable|string|max:255',
            'last_name_ru' => 'required|string|max:255',
            'last_name_en' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'professions_uz' => 'required|string|max:255',
            'professions_uz_cy' => 'nullable|string|max:255',
            'professions_ru' => 'required|string|max:255',
            'professions_en' => 'required|string|max:255',
            'biography_uz' => 'nullable|string',
            'biography_uz_cy' => 'nullable|string',
            'biography_ru' => 'nullable|string',
            'biography_en' => 'nullable|string',
            'live_place' => 'nullable|integer|min:1|exists:countries_regions,id',
            'original_name' => 'nullable|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'nicknames' => 'nullable|string|max:255',
            'birth_date' => 'required_with_all:birth_place|nullable|date_format:Y-m-d',
            'birth_place' => 'required_with_all:birth_date|nullable|integer|min:1|exists:countries_regions,id',
            'death_date' => 'required_with_all:death_place|nullable|date_format:Y-m-d',
            'death_place' => 'required_with_all:death_date|nullable|integer|min:1|exists:countries_regions,id',
            'gender' => ['numeric', Rule::in(array_keys(Celebrity::gendersList()))],
            'height_foot' => 'nullable|numeric',
            'height_meter' => 'nullable|numeric',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'google_plus' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:celebrity_celebrities,slug,' . $this->celebrity->id . ',id',
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_keywords' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
        ];
    }
}
