<?php

namespace App\Services\Manage\Celebrity;

use App\Http\Requests\Admin\Celebrity\Relatives\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Relatives\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\CelebrityRelative;

class CelebrityRelativeService
{
    public function addRelative(int $id, CreateRequest $request): CelebrityRelative
    {
        $celebrity = Celebrity::findOrFail($id);

        if ($celebrity->id === (int)$request->relative_id) {
            throw new \RuntimeException('Celebrity cannot be relative to himself/herself.');
        }

        return $celebrity->relatives()->create([
            'relative_id' => $request->relative_id,
            'first_name_uz' => $request->first_name_uz,
            'first_name_uz_cy' => $request->first_name_uz_cy,
            'first_name_ru' => $request->first_name_ru,
            'first_name_en' => $request->first_name_en,
            'last_name_uz' => $request->last_name_uz,
            'last_name_uz_cy' => $request->last_name_uz_cy,
            'last_name_ru' => $request->last_name_ru,
            'last_name_en' => $request->last_name_en,
            'middle_name_uz' => $request->middle_name_uz,
            'middle_name_uz_cy' => $request->middle_name_uz_cy,
            'middle_name_ru' => $request->middle_name_ru,
            'middle_name_en' => $request->middle_name_en,
            'relation_type' => $request->relation_type,
            'marry_date' => $request->marry_date,
            'divorce_date' => $request->divorce_date,
            'divorce_reason' => $request->divorce_reason,
            'children' => $request->children,
        ]);
    }

    public function updateRelative(int $id, int $quoteId, UpdateRequest $request): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $relative = $celebrity->relatives()->findOrFail($quoteId);

        if ($celebrity->id === $request->relative_id) {
            throw new \RuntimeException('Celebrity cannot be relative to himself/herself.');
        }

        $relative->update([
            'relative_id' => $request->relative_id,
            'first_name_uz' => $request->first_name_uz,
            'first_name_uz_cy' => $request->first_name_uz_cy,
            'first_name_ru' => $request->first_name_ru,
            'first_name_en' => $request->first_name_en,
            'last_name_uz' => $request->last_name_uz,
            'last_name_uz_cy' => $request->last_name_uz_cy,
            'last_name_ru' => $request->last_name_ru,
            'last_name_en' => $request->last_name_en,
            'middle_name_uz' => $request->middle_name_uz,
            'middle_name_uz_cy' => $request->middle_name_uz_cy,
            'middle_name_ru' => $request->middle_name_ru,
            'middle_name_en' => $request->middle_name_en,
            'relation_type' => $request->relation_type,
            'marry_date' => $request->marry_date,
            'divorce_date' => $request->divorce_date,
            'divorce_reason' => $request->divorce_reason,
            'children' => $request->children,
        ]);
    }
}
