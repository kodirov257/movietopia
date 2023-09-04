<?php

namespace App\Services\Manage\Celebrity;

use App\Entity\Meta;
use App\Helpers\ImageHelper;
use App\Http\Requests\Admin\Celebrity\Celebrities\BiographyRequest;
use App\Http\Requests\Admin\Celebrity\Celebrities\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Celebrities\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CelebrityService
{
    private ?int $nextId = null;

    public function create(CreateRequest $request): Celebrity
    {
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $professionsUz = array_map('trim', explode(',', $request->professions_uz));
        $professionsUzCy = array_map('trim', explode(',', $request->professions_uz_cy));
        $professionsRu = array_map('trim', explode(',', $request->professions_ru));
        $professionsEn = array_map('trim', explode(',', $request->professions_en));
        $nicknames = array_map('trim', explode(',', $request->nicknames));

        $celebrity = Celebrity::make([
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
            'professions_uz' => $professionsUz,
            'professions_uz_cy' => $professionsUzCy,
            'professions_ru' => $professionsRu,
            'professions_en' => $professionsEn,
            'biography_uz' => $request->biography_uz,
            'biography_uz_cy' => $request->biography_uz_cy,
            'biography_ru' => $request->biography_ru,
            'biography_en' => $request->biography_en,
            'live_place' => $request->live_place,
            'original_name' => $request->original_name,
            'birth_name' => $request->birth_name,
            'nicknames' => $nicknames,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'death_date' => $request->death_date,
            'death_place' => $request->death_place,
            'gender' => $request->gender,
            'height_foot' => $request->height_foot,
            'height_meter' => $request->height_meter,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'google_plus' => $request->google_plus,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);

        if (!$request->live_place && $request->birth_place) {
            $celebrity->live_place = $request->birth_place;
        }

        if ($request->photo) {
            $imageName = ImageHelper::getRandomName($request->photo);
            $celebrity->id = $this->getNextId();
            $celebrity->photo = $imageName;

            $celebrity->save();

            $this->uploadPhoto($celebrity->id, $request->photo, $imageName);

            return $celebrity;
        }

        $celebrity->save();

        return $celebrity;
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $celebrity = Celebrity::findOrFail($id);
        $meta = new Meta($request->meta_title, $request->meta_keywords, $request->meta_description);

        $professionsUz = array_map('trim', explode(',', $request->professions_uz));
        $professionsUzCy = array_map('trim', explode(',', $request->professions_uz_cy));
        $professionsRu = array_map('trim', explode(',', $request->professions_ru));
        $professionsEn = array_map('trim', explode(',', $request->professions_en));
        $nicknames = array_map('trim', explode(',', $request->nicknames));

        if ($request->photo) {
            Storage::disk('public')->deleteDirectory('/files/' . ImageHelper::FOLDER_CELEBRITIES . '/' . $celebrity->id);
            $imageName = ImageHelper::getRandomName($request->photo);
            $celebrity->photo = $imageName;
        }

        $celebrity->update([
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
            'professions_uz' => $professionsUz,
            'professions_uz_cy' => $professionsUzCy,
            'professions_ru' => $professionsRu,
            'professions_en' => $professionsEn,
            'biography_uz' => $request->biography_uz,
            'biography_uz_cy' => $request->biography_uz_cy,
            'biography_ru' => $request->biography_ru,
            'biography_en' => $request->biography_en,
            'live_place' => $request->live_place,
            'original_name' => $request->original_name,
            'birth_name' => $request->birth_name,
            'nicknames' => $nicknames,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'death_date' => $request->death_date,
            'death_place' => $request->death_place,
            'gender' => $request->gender,
            'height_foot' => $request->height_foot,
            'height_meter' => $request->height_meter,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'google_plus' => $request->google_plus,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'slug' => $request->slug,
            'meta_json' => $meta,
        ]);

        if (isset($imageName)) {
            $this->uploadPhoto($celebrity->id, $request->photo, $celebrity->photo);
        }
    }

    public function getNextId(): int
    {
        if (!$this->nextId) {
            $nextId = DB::select("select nextval('celebrity_celebrities_id_seq')");
            return $this->nextId = (int)$nextId['0']->nextval;
        }
        return $this->nextId;
    }

    public function remove(int $id): bool
    {
        $celebrity = Celebrity::findOrFail($id);
        DB::beginTransaction();
        try {
            $celebrity->relatives()->delete();
            $celebrity->trademarks()->delete();
            $celebrity->trivia()->delete();
            $celebrity->quotes()->delete();

            if ($celebrity->photo) {
                $this->deletePhoto($celebrity->id);
            }

            $celebrity->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateBiography(int $id, BiographyRequest $request): void
    {
        $celebrity = Celebrity::findOrFail($id);

        $celebrity->update([
            'biography_uz' => $request->biography_uz,
            'biography_uz_cy' => $request->biography_uz_cy,
            'biography_ru' => $request->biography_ru,
            'biography_en' => $request->biography_en,
        ]);
    }

    public function removePhoto(int $id): bool
    {
        $celebrity = Celebrity::findOrFail($id);

        return $this->deletePhoto($id) && $celebrity->update(['photo' => null]);
    }

    public function deletePhoto(int $id): bool
    {
        return Storage::disk('public')->deleteDirectory('/files/' . ImageHelper::FOLDER_CELEBRITIES . '/' . $id);
    }

    private function uploadPhoto(int $markId, UploadedFile $photo, string $imageName): void
    {
        ImageHelper::saveThumbnail($markId, ImageHelper::FOLDER_CELEBRITIES, $photo, $imageName);
        ImageHelper::saveCustom($markId, ImageHelper::FOLDER_CELEBRITIES, $photo, $imageName, 128, 96);
        ImageHelper::saveOriginal($markId, ImageHelper::FOLDER_CELEBRITIES, $photo, $imageName);
    }
}
