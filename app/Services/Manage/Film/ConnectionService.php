<?php

namespace App\Services\Manage\Film;

use App\Http\Requests\Admin\Film\Connections\CreateRequest;
use App\Http\Requests\Admin\Film\Connections\UpdateRequest;
use App\Models\Film\Film;
use App\Models\Film\FilmConnection;
use Illuminate\Support\Facades\DB;

class ConnectionService
{
    /**
     * @throws \Throwable
     */
    public function addConnection(int $id, CreateRequest $request): FilmConnection
    {
        $film = Film::findOrFail($id);
        $connectedFilm = Film::findOrFail($request->connected_film_id);

        DB::beginTransaction();
        try {
            $filmConnection = $film->filmConnections()->create([
                'connected_film_id' => $connectedFilm->id,
                'connection_uz' => $request->connection_uz,
                'connection_uz_cy' => $request->connection_uz_cy,
                'connection_ru' => $request->connection_ru,
                'connection_en' => $request->connection_en,
                'type' => $request->type,
            ]);

            $this->sortConnections($film);

            DB::commit();

            return $filmConnection;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateConnection(int $id, int $connectionId, UpdateRequest $request): void
    {
        $film = Film::findOrFail($id);
        $filmConnection = $film->filmConnections()->findOrFail($connectionId);
        $connectedFilm = Film::findOrFail($request->connected_film_id);

        $filmConnection->update([
            'connected_film_id' => $connectedFilm->id,
            'connection_uz' => $request->connection_uz,
            'connection_uz_cy' => $request->connection_uz_cy,
            'connection_ru' => $request->connection_ru,
            'connection_en' => $request->connection_en,
            'type' => $request->type,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function remove(int $id, int $connectionId): void
    {
        $film = Film::findOrFail($id);
        $filmConnection = $film->filmConnections()->findOrFail($connectionId);

        DB::beginTransaction();
        try {
            $filmConnection->delete();

            $this->sortConnections($film);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function moveConnectionToFirst(int $id, int $connectionId): void
    {
        $film = Film::findOrFail($id);
        $filmConnections = $film->filmConnections;

        foreach ($filmConnections as $i => $filmConnection) {
            if ($filmConnection->isIdEqualTo($connectionId)) {
                for ($j = $i; $j >= 0; $j--) {
                    if (!isset($filmConnections[$j - 1])) {
                        break(1);
                    }

                    $prev = $filmConnections[$j - 1];
                    $filmConnections[$j - 1] = $filmConnections[$j];
                    $filmConnections[$j] = $prev;
                }
                $film->filmConnections = $filmConnections;

                DB::beginTransaction();
                try {
                    $this->sortConnections($film);
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
    public function moveConnectionUp(int $id, int $connectionId): void
    {
        $film = Film::findOrFail($id);
        $filmConnections = $film->filmConnections;

        foreach ($filmConnections as $i => $filmConnection) {
            if ($filmConnection->isIdEqualTo($connectionId)) {
                if (!isset($filmConnections[$i - 1])) {
                    $count = count($filmConnections);

                    for ($j = 1; $j < $count; $j++) {
                        $next = $filmConnections[$j - 1];
                        $filmConnections[$j - 1] = $filmConnections[$j];
                        $filmConnections[$j] = $next;
                    }
                } else {
                    $previous = $filmConnections[$i - 1];
                    $filmConnections[$i - 1] = $filmConnection;
                    $filmConnections[$i] = $previous;
                }
                $film->filmConnections = $filmConnections;

                DB::beginTransaction();
                try {
                    $this->sortConnections($film);
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
    public function moveConnectionDown(int $id, int $connectionId): void
    {
        $film = Film::findOrFail($id);
        $filmConnections = $film->filmConnections;

        foreach ($filmConnections as $i => $filmConnection) {
            if ($filmConnection->isIdEqualTo($connectionId)) {
                if (!isset($filmConnections[$i + 1])) {
                    $last = $filmConnections->last();
                    $count = count($filmConnections);

                    for ($j = $count - 1; $j > 0; $j--) {
                        $filmConnections[$j] = $filmConnections[$j - 1];
                    }

                    $filmConnections[$j] = $last;
                } else {
                    $next = $filmConnections[$i + 1];
                    $filmConnections[$i + 1] = $filmConnection;
                    $filmConnections[$i] = $next;
                }
                $film->filmConnections = $filmConnections;

                DB::beginTransaction();
                try {
                    $this->sortConnections($film);
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
    public function moveConnectionToLast(int $id, int $connectionId): void
    {
        $film = Film::findOrFail($id);
        $filmConnections = $film->filmConnections;

        foreach ($filmConnections as $i => $filmConnection) {
            if ($filmConnection->isIdEqualTo($connectionId)) {
                $count = count($filmConnections);
                for ($j = $i; $j < $count; $j++) {
                    if (!isset($filmConnections[$j + 1])) {
                        break(1);
                    }

                    $next = $filmConnections[$j + 1];
                    $filmConnections[$j + 1] = $filmConnections[$j];
                    $filmConnections[$j] = $next;
                }
                $film->filmConnections = $filmConnections;

                DB::beginTransaction();
                try {
                    $this->sortConnections($film);
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
    private function sortConnections(Film $film): void
    {
        foreach ($film->filmConnections as $i => $filmConnection) {
            $filmConnection->setSort($i + 1);
            $filmConnection->saveOrFail();
        }
    }
}
