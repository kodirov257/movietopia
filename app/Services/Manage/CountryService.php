<?php

namespace App\Services\Manage;

use App\Entity\Meta;
use App\Http\Requests\Admin\Countries\CreateRequest;
use App\Http\Requests\Admin\Countries\UpdateRequest;
use App\Models\Country;

class CountryService
{
    public function create(CreateRequest $request): Country
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        return Country::create([
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
        $country = Country::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $country->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);
    }
}
