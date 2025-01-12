<?php

namespace App\Services\Manage;

use App\Entity\Meta;
use App\Http\Requests\Admin\Companies\CreateRequest;
use App\Http\Requests\Admin\Companies\UpdateRequest;
use App\Models\Company;

class CompanyService
{
    public function create(CreateRequest $request): Company
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        return Company::create([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'url' => $request->url,
            'meta_json' => $meta,
        ]);
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $company = Company::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $company->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
            'url' => $request->url,
            'meta_json' => $meta,
        ]);
    }
}
