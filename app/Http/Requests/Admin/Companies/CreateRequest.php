<?php

namespace App\Http\Requests\Admin\Companies;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 * @property string $name_uz
 * @property string $name_uz_cy
 * @property string $name_ru
 * @property string $name_en
 * @property string $slug
 * @property string $url
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
            'name_uz' => 'required|string|max:255',
            'name_uz_cy' => 'nullable|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:genres',
            'url' => 'required|string|max:255',
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_keywords' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
        ];
    }
}
