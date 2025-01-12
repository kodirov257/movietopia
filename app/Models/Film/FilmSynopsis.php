<?php

namespace App\Models\Film;

use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $film_id
 * @property string $synopsis_uz
 * @property string $synopsis_uz_cy
 * @property string $synopsis_ru
 * @property string $synopsis_en
 * @property string $type
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $synopsis
 * @property Film $film
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmSynopsis extends BaseModel
{
    public const TYPE_SUMMARY = 'summary';
    public const TYPE_SYNOPSIS = 'synopsis';

    protected $table = 'film_film_synopses';

    protected $fillable = [
        'film_id', 'synopsis_uz', 'synopsis_uz_cy', 'synopsis_ru', 'synopsis_en', 'type', 'sort',
    ];

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo(int $id): bool
    {
        return $this->id === $id;
    }

    public static function typesList(): array
    {
        return [
            self::TYPE_SUMMARY => __('movie.film.summary'),
            self::TYPE_SYNOPSIS => __('movie.film.synopsis'),
        ];
    }

    public function typeName(): string
    {
        return self::typesList()[$this->type];
    }


    ########################################### Mutators

    public function getSynopsisAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getAttribute($this, 'synopsis'));
    }

    ###########################################


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function createdBy(): BelongsTo|User
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo|User
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    ###########################################
}
