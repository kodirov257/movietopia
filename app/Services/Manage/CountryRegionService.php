<?php

namespace App\Services\Manage;

use App\Entity\Meta;
use App\Http\Requests\Admin\CountryRegions\CreateRequest;
use App\Http\Requests\Admin\CountryRegions\UpdateRequest;
use App\Models\CountryRegion;

class CountryRegionService
{
    public function create(CreateRequest $request): CountryRegion
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        return CountryRegion::create([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'type' => !$request->get('parent') ? CountryRegion::COUNTRY : $request->type,
            'parent_id' => $request->get('parent'),
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $country = CountryRegion::findOrFail($id);
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

    public static function getDescendantIds(CountryRegion $region, array &$ids): void
    {
        foreach ($region->children as $child) {
            self::getDescendantIds($child, $ids);
        }

        $ids[] = $region->id;
    }
}
