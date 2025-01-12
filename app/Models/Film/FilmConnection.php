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
 * @property int $connected_film_id
 * @property string $connection_uz
 * @property string $connection_uz_cy
 * @property string $connection_ru
 * @property string $connection_en
 * @property string $type
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $connection
 * @property Film $film
 * @property Film $connectedFilm
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmConnection extends BaseModel
{
    public const EDITED_FROM = 'edited_from';
    public const EDITED_INTO = 'edited_into';
    public const FEATURED_IN = 'featured_in';
    public const REFERENCED_IN = 'referenced_in';
    public const REFERENCES = 'references';
    public const SPIN_OFF = 'spin_off';
    public const FOLLOWED_BY = 'followed_by';
    public const FOLLOWS = 'follows';
    public const SPOOFED_IN = 'spoofed_in';
    public const VERSION_OF = 'version_of';

    protected $table = 'film_film_connections';

    protected $fillable = [
        'film_id', 'connected_film_id', 'connection_uz', 'connection_uz_cy', 'connection_ru', 'connection_en', 'sort', 'type',
    ];

    public static function typesList(): array
    {
        return [
            self::EDITED_FROM => __('movie.film.edited_from'),
            self::EDITED_INTO => __('movie.film.edited_into'),
            self::FEATURED_IN => __('movie.film.featured_in'),
            self::REFERENCED_IN => __('movie.film.referenced_in'),
            self::REFERENCES => __('movie.film.references'),
            self::SPIN_OFF => __('movie.film.spin_off'),
            self::FOLLOWED_BY => __('movie.film.followed_by'),
            self::FOLLOWS => __('movie.film.follows'),
            self::SPOOFED_IN => __('movie.film.spoofed_in'),
            self::VERSION_OF => __('movie.film.version_of'),
        ];
    }

    public function typeName(): string
    {
        return self::typesList()[$this->type];
    }

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isConnectedFilmIdEqualTo(int $connectedFilmId): bool
    {
        return $this->connected_film_id === $connectedFilmId;
    }


    ########################################### Mutators

    public function getConnectionAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getAttribute($this, 'connection'));
    }

    ###########################################


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function connectedFilm(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'connected_film_id', 'id');
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
