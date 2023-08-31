<?php

namespace App\Services\Manage;

use App\Entity\Meta;
use App\Http\Requests\Admin\Positions\CreateRequest;
use App\Http\Requests\Admin\Positions\UpdateRequest;
use App\Models\Position;

class PositionService
{
    public function create(CreateRequest $request): Position
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        return Position::create([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $position = Position::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $position->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);
    }
}
