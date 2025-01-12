<?php

namespace App\Services\Manage;

use App\Entity\Meta;
use App\Http\Requests\Admin\Types\CreateRequest;
use App\Http\Requests\Admin\Types\UpdateRequest;
use App\Models\Type;

class TypeService
{
    public function create(CreateRequest $request): Type
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        return Type::create([
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
        $type = Type::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $type->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);
    }
}
