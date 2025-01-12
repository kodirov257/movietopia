<?php

namespace App\Http\Requests\Admin\Celebrity\Relatives;

use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\CelebrityRelative;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $relative_id
 * @property string $first_name_uz
 * @property string $first_name_uz_cy
 * @property string $first_name_ru
 * @property string $first_name_en
 * @property string $last_name_uz
 * @property string $last_name_uz_cy
 * @property string $last_name_ru
 * @property string $last_name_en
 * @property string $middle_name_uz
 * @property string $middle_name_uz_cy
 * @property string $middle_name_ru
 * @property string $middle_name_en
 * @property string $relation_type
 * @property Carbon $marry_date
 * @property Carbon $divorce_date
 * @property string $divorce_reason
 * @property int $children
 *
 * @property Celebrity $celebrity
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
            'relative_id' => 'nullable|int|exists:celebrity_celebrities,id'/*|not_in:' . $this->celebrity->id*/,
            'first_name_uz' => 'required_without_all:relative_id|nullable|string|max:255',
            'first_name_uz_cy' => 'nullable|string|max:255',
            'first_name_ru' => 'required_without_all:relative_id|nullable|string|max:255',
            'first_name_en' => 'required_without_all:relative_id|nullable|string|max:255',
            'middle_name_uz' => 'nullable|string|max:255',
            'middle_name_uz_cy' => 'nullable|string|max:255',
            'middle_name_ru' => 'nullable|string|max:255',
            'middle_name_en' => 'nullable|string|max:255',
            'last_name_uz' => 'required_without_all:relative_id|nullable|string|max:255',
            'last_name_uz_cy' => 'nullable|string|max:255',
            'last_name_ru' => 'required_without_all:relative_id|nullable|string|max:255',
            'last_name_en' => 'required_without_all:relative_id|nullable|string|max:255',
            'relation_type' => ['required', 'string', Rule::in(array_keys(CelebrityRelative::relativeTypesList()))],
            'marry_date' => [
                Rule::requiredIf(
                    fn() => in_array($this->relation_type,
                        [CelebrityRelative::SPOUSE, CelebrityRelative::HUSBAND, CelebrityRelative::WIFE], true
                    )),
                'nullable', 'date'
            ],
            'divorce_date' => 'nullable|date',
            'divorce_reason' => ['nullable', 'string', Rule::in(array_keys(CelebrityRelative::divorceReasonList()))],
            'children' => 'nullable|int|min:0',
        ];
    }
}
