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
            'name_uz' => 'required|string|max:255|unique:countries_regions,name_uz,NULL,id,parent_id,' . ($this['parent'] ?: 'NULL'),
            'name_uz_cy' => 'nullable|string|max:255|unique:countries_regions,name_uz_cy,NULL,id,parent_id,' . ($this['parent'] ?: 'NULL'),
            'name_ru' => 'required|string|max:255|unique:countries_regions,name_ru,NULL,id,parent_id,' . ($this['parent'] ?: 'NULL'),
            'name_en' => 'required|string|max:255|unique:countries_regions,name_en,NULL,id,parent_id,' . ($this['parent'] ?: 'NULL'),
            'parent' => 'nullable|exists:countries_regions,id',
            'type' => ['required_with_all::parent', 'string', Rule::in([CountryRegion::STATE, CountryRegion::CITY, CountryRegion::REGION])],
            'slug' => 'nullable|string|max:255|unique:countries_regions,slug,NULL,id,parent_id,' . ($this['parent'] ?: 'NULL'),
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_keywords' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
        ];
    }
}
