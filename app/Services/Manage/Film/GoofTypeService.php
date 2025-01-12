<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\GoofTypes\CreateRequest;
use App\Http\Requests\Admin\Film\GoofTypes\UpdateRequest;
use App\Models\Film\GoofType;
use Illuminate\Support\Facades\DB;

class GoofTypeService
{
    public function create(CreateRequest $request): GoofType
    {

        return GoofType::create([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
        ]);
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $genre = GoofType::findOrFail($id);

        $genre->update([
            'name_uz' => $request->name_uz,
            'name_uz_cy' => $request->name_uz_cy,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'slug' => $request->slug,
        ]);
    }

    public function moveToFirst(int $id): void
    {
        $goofTypes = GoofType::get();

        foreach ($goofTypes as $i => $goofType) {
            if ($goofType->isIdEqualTo($id)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($goofTypes[$j - 1])) {
                        break(1);
                    }

                    $prev = $goofTypes[$j - 1];
                    $goofTypes[$j - 1] = $goofTypes[$j];
                    $goofTypes[$j] = $prev;
                }

                DB::beginTransaction();
                try {
                    $this->sortGoofTypes($goofTypes);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    public function moveUp(int $id): void
    {
        $goofTypes = GoofType::get();

        foreach ($goofTypes as $i => $goofType) {
            if ($goofType->isIdEqualTo($id)) {
                if (!isset($goofTypes[$i - 1])) {
                    $count = count($goofTypes);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $goofTypes[$j - 1];
                        $goofTypes[$j - 1] = $goofTypes[$j];
                        $goofTypes[$j] = $next;
                    }
                } else {
                    $previous = $goofTypes[$i - 1];
                    $goofTypes[$i - 1] = $goofType;
                    $goofTypes[$i] = $previous;
                }

                DB::beginTransaction();
                try {
                    $this->sortGoofTypes($goofTypes);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    public function moveDown(int $id): void
    {
        $goofTypes = GoofType::get();

        foreach ($goofTypes as $i => $goofType) {
            if ($goofType->isIdEqualTo($id)) {
                if (!isset($goofTypes[$i + 1])) {
                    $last = $goofTypes->last();
                    $count = count($goofTypes);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $goofTypes[$j] = $goofTypes[$j - 1];
                    }

                    $goofTypes[$j] = $last;
                } else {
                    $next = $goofTypes[$i + 1];
                    $goofTypes[$i + 1] = $goofType;
                    $goofTypes[$i] = $next;
                }

                DB::beginTransaction();
                try {
                    $this->sortGoofTypes($goofTypes);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    public function moveToLast(int $id): void
    {
        $goofTypes = GoofType::get();

        foreach ($goofTypes as $i => $goofType) {
            if ($goofType->isIdEqualTo($id)) {
                $count = count($goofTypes);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($goofTypes[$j + 1])) {
                        break(1);
                    }

                    $next = $goofTypes[$j + 1];
                    $goofTypes[$j + 1] = $goofTypes[$j];
                    $goofTypes[$j] = $next;
                }

                DB::beginTransaction();
                try {
                    $this->sortGoofTypes($goofTypes);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                return;
            }
        }
    }

    /**
     * @param GoofType[] $goofTypes
     * @return void
     */
    private function sortGoofTypes(array $goofTypes): void
    {
        foreach ($goofTypes as $i => $goofType) {
            $goofType->setSort($i + 1);
            $goofType->save();
        }
    }
}
