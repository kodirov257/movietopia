<?php

namespace App\Http\Requests\Admin\Film\Credits;

use App\Models\Film\FilmCredit;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $credit_uz
 * @property string $credit_uz_cy
 * @property string $credit_ru
 * @property string $credit_en
 *
 * @property FilmCredit $film_credit
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
            'credit_uz' => 'required|string',
            'credit_uz_cy' => 'nullable|string',
            'credit_ru' => 'required|string',
            'credit_en' => 'required|string',
        ];
    }
}
