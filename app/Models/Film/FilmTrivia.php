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
 * @property string $trivia_uz
 * @property string $trivia_uz_cy
 * @property string $trivia_ru
 * @property string $trivia_en
 * @property string $type
 * @property bool $spoiler
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $trivia
 * @property Film $film
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmTrivia extends BaseModel
{
    public const TYPE_DEFAULT = 'default';
    public const TYPE_CAMEO = 'cameo';
    public const TYPE_DIRECTOR_TRADEMARK = 'director_trademark';

    protected $table = 'film_film_trivias';

    protected $fillable = [
        'film_id', 'trivia_uz', 'trivia_uz_cy', 'trivia_ru', 'trivia_en', 'type', 'spoiler', 'sort',
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
            self::TYPE_DEFAULT => __('movie.film.default'),
            self::TYPE_CAMEO => __('movie.film.cameo'),
            self::TYPE_DIRECTOR_TRADEMARK => __('movie.film.director_trademark'),
        ];
    }

    public function typeName(): string
    {
        return self::typesList()[$this->type];
    }


    ########################################### Mutators

    public function getTriviaAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getTrivia($this));
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
