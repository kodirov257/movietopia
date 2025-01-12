<?php

namespace App\Http\Requests\Admin\Types;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name_uz
 * @property string $name_uz_cy
 * @property string $name_ru
 * @property string $name_en
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Type $type
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
            'name_uz' => 'required|string|max:255|unique:film_types,name_uz,' . $this->type->id . ',id',
            'name_uz_cy' => 'nullable|string|max:255|unique:film_types,name_uz_cy,' . $this->type->id . ',id',
            'name_ru' => 'required|string|max:255|unique:film_types,name_ru,' . $this->type->id . ',id',
            'name_en' => 'required|string|max:255|unique:film_types,name_en,' . $this->type->id . ',id',
            'slug' => 'nullable|string|max:255|unique:film_types,slug,' . $this->type->id . ',id',
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_keywords' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string'],
        ];
    }
}
