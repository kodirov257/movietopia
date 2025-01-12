<?php

namespace App\Http\Requests\Admin\CountryRegions;

use App\Models\CountryRegion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $name_uz
 * @property string $name_uz_cy
 * @property string $name_ru
 * @property string $name_en
 * @property string $type
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property CountryRegion $country_region
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
            'name_uz' => 'required|string|max:255|unique:countries_regions,name_uz,' . $this->country_region->id . ',id,parent_id,' . ($this->country_region->parent_id ?: 'NULL'),
            'name_uz_cy' => 'nullable|string|max:255|unique:countries_regions,name_uz_cy,' . $this->country_region->id . ',id,parent_id,' . ($this->country_region->parent_id ?: 'NULL'),
            'name_ru' => 'required|string|max:255|unique:countries_regions,name_ru,' . $this->country_region->id . ',id,parent_id,' . ($this->country_region->parent_id ?: 'NULL'),
            'name_en' => 'required|string|max:255|unique:countries_regions,name_en,' . $this->country_region->id . ',id,parent_id,' . ($this->country_region->parent_id ?: 'NULL'),
//            'slug' => ['nullable', 'string', 'max:255', Rule::unique('countries_regions')->ignore($this->countryRegion->id)],
            'slug' => 'nullable|string|max:255|unique:countries_regions,slug,' . $this->country_region->id . ',id,parent_id,' . ($this->country_region->parent_id ?: 'NULL'),
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_keywords' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
        ];
    }
}
