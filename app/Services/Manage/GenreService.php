<?php

namespace App\Services\Manage;

use App\Entity\Meta;
use App\Http\Requests\Admin\Genres\CreateRequest;
use App\Http\Requests\Admin\Genres\UpdateRequest;
use App\Models\Genre;

class GenreService
{
    public function create(CreateRequest $request): Genre
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        return Genre::create([
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
        $genre = Genre::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $genre->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);
    }
}
