<?php

namespace App\Models\Film;

use App\Casts\MetaJson;
use App\Entity\Meta;
use App\Helpers\ImageHelper;
use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\Company;
use App\Models\CountryRegion;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Type;
use App\Models\User\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title_uz
 * @property string $title_uz_cy
 * @property string $title_ru
 * @property string $title_en
 * @property string $original_title
 * @property string $description_uz
 * @property string $description_uz_cy
 * @property string $description_ru
 * @property string $description_en
 * @property string $storyline_uz
 * @property string $storyline_uz_cy
 * @property string $storyline_ru
 * @property string $storyline_en
 * @property string $slug
 * @property bool $tv_series
 * @property int $status
 * @property string $poster
 * @property int $age_rating
 * @property float $film_rating
 * @property int $film_rating_number
 * @property int $duration_minutes
 * @property Carbon $world_released_at
 * @property Carbon $last_season_released_at
 * @property Carbon $last_episode_released_at
 * @property bool $budget_estimated
 * @property string $budget_from
 * @property string $budget_to
 * @property string $box_office_local
 * @property string $box_office_worldwide
 * @property Carbon $filming_date_from
 * @property Carbon $filming_date_to
 * @property array $sites
 * @property float $imdb_rating
 * @property int $imdb_rating_voting
 * @property Meta $meta_json
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $title
 * @property string $description
 * @property string $posterThumbnail
 * @property string $posterCustom
 * @property string $posterOriginal
 *
 * @property FilmSlogan[] $slogans
 * @property FilmSlogan $mainSlogan
 * @property FilmSynopsis[] $synopses
 * @property FilmTrivia[] $trivias
 * @property FilmGoof[] $goofs
 * @property FilmCredit[] $credits
 * @property FilmConnection[] $filmConnections
 * @property Film[] $connectedFilms
 * @property FilmTitle[] $titles
 * @property FilmCountry[] $filmCountries
 * @property CountryRegion[] $countries
 * @property FilmLanguage[] $filmLanguages
 * @property Language[] $languages
 * @property FilmLocation[] $filmLocations
 * @property CountryRegion[] $locations
 * @property FilmCompany[] $filmCompanies
 * @property FilmReleaseDate[] $releaseDates
 * @property Company[] $companies
 * @property FilmGenre[] $filmGenres
 * @property Genre[] $genres
 * @property FilmType[] $filmTypes
 * @property Type[] $types
 * @property FilmAlternateVersion[] $alternateVersions
 * @property FilmAlternateVersion $mainAlternateVersions
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class Film extends BaseModel
{
    use HasFactory, Sluggable, SoftDeletes;

    public const STATUS_DRAFT = 0;
    public const STATUS_MODERATION = 1;
    public const STATUS_DELETED = 2;
    public const STATUS_ACTIVE = 10;

    protected $table = 'film_films';

    protected $fillable = [
        'id', 'title_uz', 'title_uz_cy', 'title_ru', 'title_en', 'original_title', 'description_uz', 'description_uz_cy',
        'description_ru', 'description_en', 'storyline_uz', 'storyline_uz_cy', 'storyline_ru', 'storyline_en', 'slug',
        'tv_series', 'status', 'poster', 'age_rating', 'film_rating', 'film_rating_number', 'duration_minutes',
        'world_released_at', 'last_season_released_at', 'last_episode_released_at', 'budget_estimated', 'budget_from',
        'budget_to', 'box_office_local', 'box_office_worldwide', 'filming_date_from', 'filming_date_to', 'imdb_rating',
        'imdb_rating_votes', 'meta_json', 'sites',
    ];

    protected $casts = [
        'world_released_at' => 'date',
        'last_season_released_at' => 'date',
        'filming_date_from' => 'date',
        'filming_date_to' => 'date',
        'sites' => 'array',
        'meta_json' => MetaJson::class,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title_en',
            ]
        ];
    }

    public static function statusesList(): array
    {
        return [
            self::STATUS_DRAFT => __('adminlte.film.draft'),
            self::STATUS_MODERATION => __('adminlte.film.moderation'),
            self::STATUS_DELETED => __('adminlte.film.deleted'),
            self::STATUS_ACTIVE => __('adminlte.film.active'),
        ];
    }

    public function statusName(): string
    {
        return self::statusesList()[$this->status];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => '<span class="badge badge-secondary">' . __('adminlte.film.draft') . '</span>',
            self::STATUS_MODERATION => '<span class="badge badge-warning">' . __('adminlte.film.moderation') . '</span>',
            self::STATUS_ACTIVE => '<span class="badge badge-success">' . __('adminlte.film.active') . '</span>',
            self::STATUS_DELETED => '<span class="badge badge-danger">' . __('adminlte.film.deleted') . '</span>',
            default => '<span class="badge badge-danger">Default</span>',
        };
    }

    public function sendToModeration(): void
    {
        if (!$this->isDraft() && !$this->isClosed()) {
            throw new \DomainException('Film is not draft or closed.');
        }

        $this->update([
            'status' => self::STATUS_MODERATION,
        ]);
    }

    public function moderate(): void
    {
        if ($this->status !== self::STATUS_MODERATION) {
            throw new \DomainException('Film is not sent to moderation.');
        }
        $this->update([
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function activate(): void
    {
        if ($this->status === self::STATUS_ACTIVE) {
            throw new \DomainException('Film is already activated.');
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function draft(): void
    {
        if ($this->status === self::STATUS_DRAFT) {
            throw new \DomainException('Film is already draft.');
        }
        $this->update([
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function close(): void
    {
        if ($this->status === self::STATUS_DELETED) {
            throw new \DomainException('Film is already closed.');
        }
        $this->update([
            'status' => self::STATUS_DELETED,
        ]);
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isOnModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isClosed(): bool
    {
        return $this->status === self::STATUS_DELETED;
    }

    public function genresList(): array
    {
        return $this->filmGenres()->pluck('genre_id')->toArray();
    }

    public function typesList(): array
    {
        return $this->filmTypes()->pluck('type_id')->toArray();
    }

    public function companiesList(): array
    {
        return $this->filmCompanies()->pluck('company_id')->toArray();
    }


    ########################################### Mutators

    public function getTitleAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getTitle($this));
    }

    public function getDescriptionAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getDescription($this));
    }

    public function getPosterThumbnailAttribute(): string
    {
        return '/storage/files/' . ImageHelper::FOLDER_FILMS . '/' . $this->id . '/' . ImageHelper::TYPE_THUMBNAIL . '/' . $this->poster;
    }

    public function getPosterCustomAttribute(): string
    {
        return '/storage/files/' . ImageHelper::FOLDER_FILMS . '/' . $this->id . '/' . ImageHelper::TYPE_CUSTOM . '/' . $this->poster;
    }

    public function getPosterOriginalAttribute(): string
    {
        return '/storage/files/' . ImageHelper::FOLDER_FILMS . '/' . $this->id . '/' . ImageHelper::TYPE_ORIGINAL . '/' . $this->poster;
    }

    ###########################################


    ########################################### Relations

    /**
     * @return HasMany|FilmSlogan[]
     */
    public function slogans(): HasMany|array
    {
        return $this->hasMany(FilmSlogan::class, 'film_id', 'id')->orderByDesc('main')->orderBy('sort');
    }

    public function mainSlogan(): HasOne|FilmSlogan
    {
        return $this->hasOne(FilmSlogan::class, 'film_id', 'id')->where('main', true);
    }

    /**
     * @return HasMany|FilmSynopsis[]
     */
    public function synopses(): HasMany|array
    {
        return $this->hasMany(FilmSynopsis::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return HasMany|FilmTrivia[]
     */
    public function trivias(): HasMany|array
    {
        return $this->hasMany(FilmTrivia::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return HasMany|FilmGoof[]
     */
    public function goofs(): HasMany|array
    {
        return $this->hasMany(FilmGoof::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return HasMany|FilmCredit[]
     */
    public function credits(): HasMany|array
    {
        return $this->hasMany(FilmCredit::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return HasMany|FilmConnection[]
     */
    public function filmConnections(): HasMany|array
    {
        return $this->hasMany(FilmConnection::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return BelongsToMany|self[]
     */
    public function connectedFilms(): BelongsToMany|array
    {
        return $this->belongsToMany(self::class, 'film_film_connections', 'film_id', 'connected_film_id', 'id', 'id')
            ->using(FilmConnection::class)
            ->withPivot('connection_uz', 'connection_uz_cy', 'connection_ru', 'connection_en', 'sort', 'type', 'created_by', 'updated_by')
            ->withTimestamps()
            ->orderByPivot('sort');
    }

    /**
     * @return HasMany|FilmTitle[]
     */
    public function titles(): HasMany|array
    {
        return $this->hasMany(FilmTitle::class, 'film_id', 'id')->with('language')->orderBy('language.name_en');
    }

    /**
     * @return HasMany|FilmCountry[]
     */
    public function filmCountries(): HasMany|array
    {
        return $this->hasMany(FilmCountry::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return BelongsToMany|CountryRegion[]
     */
    public function countries(): BelongsToMany|array
    {
        return $this->belongsToMany(CountryRegion::class, 'film_film_countries', 'film_id', 'country_id')
            ->using(FilmCountry::class)
            ->withPivot('sort', 'created_by', 'updated_by')
            ->withTimestamps()
            ->orderByPivot('sort');
    }

    /**
     * @return HasMany|FilmCountry[]
     */
    public function filmLanguages(): HasMany|array
    {
        return $this->hasMany(FilmLanguage::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return BelongsToMany|Language[]
     */
    public function languages(): BelongsToMany|array
    {
        return $this->belongsToMany(Language::class, 'film_film_languages', 'film_id', 'language_id')
            ->using(FilmLanguage::class)
            ->withPivot('sort', 'created_by', 'updated_by')
            ->withTimestamps()
            ->orderByPivot('sort');
    }

    /**
     * @return HasMany|FilmLocation[]
     */
    public function filmLocations(): HasMany|array
    {
        return $this->hasMany(FilmLocation::class, 'film_id', 'id')->orderBy('sort');
    }

    /**
     * @return BelongsToMany|CountryRegion[]
     */
    public function locations(): BelongsToMany|array
    {
        return $this->belongsToMany(CountryRegion::class, 'film_film_locations', 'film_id', 'location_id')
            ->using(FilmLocation::class)
            ->withPivot('details_uz', 'details_uz_cy', 'details_ru', 'details_en', 'sort', 'created_by', 'updated_by')
            ->withTimestamps()
            ->orderByPivot('sort');
    }

    /**
     * @return HasMany|FilmCompany[]
     */
    public function filmCompanies(): HasMany|array
    {
        return $this->hasMany(FilmCompany::class, 'film_id', 'id')->orderBy('type')->orderBy('sort');
    }

    /**
     * @return MorphMany|FilmReleaseDate[]
     */
    public function releaseDates(): MorphMany|array
    {
        return $this->morphMany(FilmReleaseDate::class, 'model')->orderBy('sort');
    }

    /**
     * @return BelongsToMany|Company[]
     */
    public function companies(): BelongsToMany|array
    {
        return $this->belongsToMany(Company::class, 'film_film_companies', 'film_id', 'company_id')
            ->using(FilmCompany::class)
            ->withPivot('details_uz', 'details_uz_cy', 'details_ru', 'details_en', 'sort', 'date', 'created_by', 'updated_by')
            ->withTimestamps()
            ->orderByPivot('sort');
    }

    /**
     * @return HasMany|FilmGenre[]
     */
    public function filmGenres(): HasMany|array
    {
        return $this->hasMany(FilmGenre::class, 'film_id', 'id');
    }

    /**
     * @return BelongsToMany|Genre[]
     */
    public function genres(): BelongsToMany|array
    {
        return $this->belongsToMany(Genre::class, 'film_film_genres', 'film_id', 'genre_id')
            ->using(FilmGenre::class);
    }

    /**
     * @return HasMany|FilmType[]
     */
    public function filmTypes(): HasMany|array
    {
        return $this->hasMany(FilmType::class, 'film_id', 'id');
    }

    /**
     * @return BelongsToMany|Type[]
     */
    public function types(): BelongsToMany|array
    {
        return $this->belongsToMany(Type::class, 'film_film_types', 'film_id', 'type_id')
            ->using(FilmType::class)
            ->withPivot('created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * @return HasMany|FilmAlternateVersion[]
     */
    public function alternateVersions(): HasMany|array
    {
        return $this->hasMany(FilmAlternateVersion::class, 'film_id', 'id')->orderBy('sort');
    }

    public function mainAlternateVersion(): HasOne|FilmAlternateVersion
    {
        return $this->hasOne(FilmAlternateVersion::class, 'film_id', 'id')->where('main', true);
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
