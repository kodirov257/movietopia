<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\AlternateVersions\CreateRequest;
use App\Http\Requests\Admin\Film\AlternateVersions\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmAlternateVersion;
use Illuminate\Support\Facades\DB;

class AlternateVersionService
{
    /**
     * @throws \Throwable
     */
    public function add(int $id, CreateRequest $request): FilmAlternateVersion
    {
        $film = Film::findOrFail($id);

        DB::beginTransaction();
        try {
            $alternateVersion = $film->alternateVersions()->create([
                'version_uz' => $request->version_uz,
                'version_uz_cy' => $request->version_uz_cy,
                'version_ru' => $request->version_ru,
                'version_en' => $request->version_en,
                'main' => $request->main,
            ]);

            $this->sortAlternateVersions($film);

            DB::commit();

            return $alternateVersion;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $id, int $alternateVersionId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $alternateVersion = $film->alternateVersions()->findOrFail($alternateVersionId);

        $alternateVersion->update([
            'version_uz' => $request->version_uz,
            'version_uz_cy' => $request->version_uz_cy,
            'version_ru' => $request->version_ru,
            'version_en' => $request->version_en,
            'main' => $request->main,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $alternateVersionId): void
    {
        $film = Film::findOrFail($id);
        $alternateVersion = $film->alternateVersions()->findOrFail($alternateVersionId);

        DB::beginTransaction();
        try {
            $alternateVersion->delete();

            $this->sortAlternateVersions($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveAlternateVersionToFirst(int $id, int $alternateVersionId): void
    {
        $film = Film::findOrFail($id);
        $alternateVersions = $film->alternateVersions;

        foreach ($alternateVersions as $i => $alternateVersion) {
            if ($alternateVersion->isIdEqualTo($alternateVersionId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($alternateVersions[$j - 1])) {
                        break(1);
                    }

                    $prev = $alternateVersions[$j - 1];
                    $alternateVersions[$j - 1] = $alternateVersions[$j];
                    $alternateVersions[$j] = $prev;
                }
                $film->alternateVersions = $alternateVersions;

                DB::beginTransaction();
                try {
                    $this->sortAlternateVersions($film);
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
     * @throws \Throwable
     */
    public function moveAlternateVersionUp(int $id, int $alternateVersionId): void
    {
        $film = Film::findOrFail($id);
        $alternateVersions = $film->alternateVersions;

        foreach ($alternateVersions as $i => $alternateVersion) {
            if ($alternateVersion->isIdEqualTo($alternateVersionId)) {
                if (!isset($alternateVersions[$i - 1])) {
                    $count = count($alternateVersions);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $alternateVersions[$j - 1];
                        $alternateVersions[$j - 1] = $alternateVersions[$j];
                        $alternateVersions[$j] = $next;
                    }
                } else {
                    $previous = $alternateVersions[$i - 1];
                    $alternateVersions[$i - 1] = $alternateVersion;
                    $alternateVersions[$i] = $previous;
                }
                $film->alternateVersions = $alternateVersions;

                DB::beginTransaction();
                try {
                    $this->sortAlternateVersions($film);
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
     * @throws \Throwable
     */
    public function moveAlternateVersionDown(int $id, int $alternateVersionId): void
    {
        $film = Film::findOrFail($id);
        $alternateVersions = $film->alternateVersions;

        foreach ($alternateVersions as $i => $alternateVersion) {
            if ($alternateVersion->isIdEqualTo($alternateVersionId)) {
                if (!isset($alternateVersions[$i + 1])) {
                    $last = $alternateVersions->last();
                    $count = count($alternateVersions);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $alternateVersions[$j] = $alternateVersions[$j - 1];
                    }

                    $alternateVersions[$j] = $last;
                } else {
                    $next = $alternateVersions[$i + 1];
                    $alternateVersions[$i + 1] = $alternateVersion;
                    $alternateVersions[$i] = $next;
                }
                $film->alternateVersions = $alternateVersions;

                DB::beginTransaction();
                try {
                    $this->sortAlternateVersions($film);
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
     * @throws \Throwable
     */
    public function moveAlternateVersionToLast(int $id, int $alternateVersionId): void
    {
        $film = Film::findOrFail($id);
        $alternateVersions = $film->alternateVersions;

        foreach ($alternateVersions as $i => $alternateVersion) {
            if ($alternateVersion->isIdEqualTo($alternateVersionId)) {
                $count = count($alternateVersions);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($alternateVersions[$j + 1])) {
                        break(1);
                    }

                    $next = $alternateVersions[$j + 1];
                    $alternateVersions[$j + 1] = $alternateVersions[$j];
                    $alternateVersions[$j] = $next;
                }
                $film->alternateVersions = $alternateVersions;

                DB::beginTransaction();
                try {
                    $this->sortAlternateVersions($film);
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
     * @throws \Throwable
     */
    private function sortAlternateVersions(Film $film): void
    {
        foreach ($film->alternateVersions as $i => $alternateVersion) {
            $alternateVersion->setSort($i + 1);
            $alternateVersion->saveOrFail();
        }
    }
}
