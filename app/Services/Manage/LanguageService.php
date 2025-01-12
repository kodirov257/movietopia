<?php

namespace App\Services\Manage;

use App\Http\Requests\Admin\Languages\CreateRequest;
use App\Http\Requests\Admin\Languages\UpdateRequest;
use App\Models\Position;

class LanguageService
{
    public function create(CreateRequest $request): Position
    {
        return Position::create([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
        ]);
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $position = Position::findOrFail($id);

        $position->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
        ]);
    }
}
