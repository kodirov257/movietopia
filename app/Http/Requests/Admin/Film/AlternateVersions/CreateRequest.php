<?php

namespace App\Http\Requests\Admin\Film\AlternateVersions;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $version_uz
 * @property string $version_uz_cy
 * @property string $version_ru
 * @property string $version_en
 * @property bool $main
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
            'version_uz' => 'required|string',
            'version_uz_cy' => 'nullable|string',
            'version_ru' => 'required|string',
            'version_en' => 'required|string',
            'main' => 'nullable|bool',
        ];
    }
}
