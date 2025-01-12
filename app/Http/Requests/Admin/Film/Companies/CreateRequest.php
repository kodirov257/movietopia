<?php

namespace App\Http\Requests\Admin\Film\Companies;

use App\Enums\FilmCompanyType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $company_id
 * @property string $type
 * @property string $details_uz
 * @property string $details_uz_cy
 * @property string $details_ru
 * @property string $details_en
 * @property Carbon $date
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
            'company_id' => 'required|int|exists:companies,id',
            'type' => ['required', 'string', Rule::in(array_keys(FilmCompanyType::typesList()))],
            'details_uz' => 'nullable|string',
            'details_uz_cy' => 'nullable|string',
            'details_ru' => 'nullable|string',
            'details_en' => 'nullable|string',
            'date' => 'nullable|date',
        ];
    }
}
