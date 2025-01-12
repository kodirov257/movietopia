<?php

namespace App\Models\Celebrity;

use App\Casts\MetaJson;
use App\Entity\Meta;
use App\Helpers\ImageHelper;
use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\CountryRegion;
use App\Models\User\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $first_name_uz
 * @property string $first_name_uz_cy
 * @property string $first_name_ru
 * @property string $first_name_en
 * @property string $last_name_uz
 * @property string $last_name_uz_cy
 * @property string $last_name_ru
 * @property string $last_name_en
 * @property string $middle_name_uz
 * @property string $middle_name_uz_cy
 * @property string $middle_name_ru
 * @property string $middle_name_en
 * @property string $photo
 * @property string[] $professions_uz
 * @property string[] $professions_uz_cy
 * @property string[] $professions_ru
 * @property string[] $professions_en
 * @property string $biography_uz
 * @property string $biography_uz_cy
 * @property string $biography_ru
 * @property string $biography_en
 * @property int $live_place
 * @property string $original_name
 * @property string $birth_name
 * @property string[] $nicknames
 * @property Carbon $birth_date
 * @property int $birth_place
 * @property Carbon $death_date
 * @property int $death_place
 * @property string $gender
 * @property float $height_foot
 * @property float $height_meter
 * @property string $twitter
 * @property string $facebook
 * @property string $instagram
 * @property string $google_plus
 * @property string $youtube
 * @property string $linkedin
 * @property string $slug
 * @property Meta $meta_json
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $middleName
 * @property string $fullName
 * @property string $professions
 * @property string $height
 * @property string $biography
 * @property string $photoThumbnail
 * @property string $photoCustom
 * @property string $photoOriginal
 *
 * @property CelebrityRelative[] $relatives
 * @property CelebrityRelative[] $spouses
 * @property CelebrityRelative[] $parents
 * @property CelebrityRelative[] $children
 * @property CelebrityRelative[] $grandparents
 * @property CountryRegion $livePlace
 * @property CountryRegion $birthPlace
 * @property CountryRegion $deathPlace
 * @property Trademark[] $trademarks
 * @property Trivia[] $trivia
 * @property Quote[] $quotes
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class Celebrity extends BaseModel
{
    use HasFactory, Sluggable;

    public const GENDER_EMPTY = 0;
    public const FEMALE = 'female';
    public const MALE = 'male';

    protected $table = 'celebrity_celebrities';

    protected $fillable = [
        'id', 'first_name_uz', 'first_name_uz_cy', 'first_name_ru', 'first_name_en', 'last_name_uz', 'last_name_uz_cy',
        'last_name_ru', 'last_name_en', 'middle_name_uz', 'middle_name_uz_cy', 'middle_name_ru', 'middle_name_en', 'photo',
        'professions_uz', 'professions_uz_cy', 'professions_ru', 'professions_en', 'biography_uz', 'biography_uz_cy',
        'biography_ru', 'biography_en', 'live_place', 'original_name', 'birth_name', 'nicknames', 'birth_date', 'birth_place',
        'death_date', 'death_place', 'gender', 'height_foot', 'height_meter', 'twitter', 'facebook', 'instagram',
        'google_plus', 'youtube',  'linkedin', 'slug', 'meta_json',
    ];

    protected $casts = [
        'birth_date' => 'datetime',
        'death_date' => 'datetime',
        'nicknames' => 'array',
        'professions_uz' => 'array',
        'professions_uz_cy' => 'array',
        'professions_ru' => 'array',
        'professions_en' => 'array',
        'meta_json' => MetaJson::class,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name_en', 'last_name_en'],
                'separator' => '-',
            ],
        ];
    }

    public static function gendersList(): array
    {
        return [
            self::GENDER_EMPTY => '',
            self::FEMALE => trans('adminlte.female'),
            self::MALE => trans('adminlte.male'),
        ];
    }

    public function genderName(): string
    {
        return self::gendersList()[$this->gender];
    }

    public function fullName($lang = null): string
    {
        $firstName = LanguageHelper::getFirstName($this, $lang);
        $middleName = LanguageHelper::getMiddleName($this, $lang);
        $lastName = LanguageHelper::getLastName($this, $lang);
        if ($middleName) {
            return htmlspecialchars_decode(sprintf('%s %s %s', $firstName, $middleName, $lastName));
        }

        return htmlspecialchars_decode(sprintf('%s %s', $firstName, $lastName));
    }

    public function getProfessions($lang = null): string
    {
        $professions = LanguageHelper::getAttribute($this, 'professions', $lang);

        if (is_array($professions)) {
            return htmlspecialchars_decode(implode(', ', $professions));
        }

        return htmlspecialchars_decode(implode(', ', json_decode($professions)));
    }

    public function getNicknames(): string
    {
        if (is_array($this->nicknames)) {
            return htmlspecialchars_decode(implode(', ', $this->nicknames));
        }

        return htmlspecialchars_decode(implode(', ', json_decode($this->nicknames)));
    }


    ########################################### Mutators

    public function getFirstNameAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getFirstName($this));
    }

    public function getLastNameAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getLastName($this));
    }

    public function getMiddleNameAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getMiddleName($this));
    }

    public function getFullNameAttribute(): string
    {
        return $this->fullName();
    }

    public function getProfessionsAttribute(): string
    {
        return $this->getProfessions();
    }

    public function getHeightAttribute(): int
    {
        if ($this->height_meter) {
            return $this->height_meter * 100;
        }

        return round($this->height_foot * 30.48, 2);
    }

    public function getBiographyAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getAttribute($this, 'biography'));
    }

    public function getPhotoThumbnailAttribute(): string
    {
        return '/storage/files/' . ImageHelper::FOLDER_CELEBRITIES . '/' . $this->id . '/' . ImageHelper::TYPE_THUMBNAIL . '/' . $this->photo;
    }

    public function getPhotoCustomAttribute(): string
    {
        return '/storage/files/' . ImageHelper::FOLDER_CELEBRITIES . '/' . $this->id . '/' . ImageHelper::TYPE_CUSTOM . '/' . $this->photo;
    }

    public function getPhotoOriginalAttribute(): string
    {
        return '/storage/files/' . ImageHelper::FOLDER_CELEBRITIES . '/' . $this->id . '/' . ImageHelper::TYPE_ORIGINAL . '/' . $this->photo;
    }

    ###########################################


    ########################################### Relations

    /**
     * @return HasMany|CelebrityRelative[]
     */
    public function relatives(): HasMany|array
    {
        return $this->hasMany(CelebrityRelative::class, 'celebrity_id', 'id');
    }

    /**
     * @return HasMany|CelebrityRelative[]
     */
    public function spouses(): HasMany|array
    {
        return $this->hasMany(CelebrityRelative::class, 'celebrity_id', 'id')
            ->whereIn('relation_type', [CelebrityRelative::SPOUSE, CelebrityRelative::HUSBAND, CelebrityRelative::WIFE])
            ->orderBy('marry_date');
    }

    /**
     * @return HasMany|CelebrityRelative[]
     */
    public function parents(): HasMany|array
    {
        return $this->hasMany(CelebrityRelative::class, 'celebrity_id', 'id')
            ->whereIn('relation_type', [CelebrityRelative::PARENTS, CelebrityRelative::FATHER, CelebrityRelative::MOTHER])
            ->orderBy('relation_type');
    }

    /**
     * @return HasMany|CelebrityRelative[]
     */
    public function children(): HasMany|array
    {
        return $this->hasMany(CelebrityRelative::class, 'celebrity_id', 'id')
            ->whereIn('relation_type', [CelebrityRelative::CHILDREN, CelebrityRelative::SON, CelebrityRelative::DAUGHTER]);
    }

    /**
     * @return HasMany|CelebrityRelative[]
     */
    public function grandparents(): HasMany|array
    {
        return $this->hasMany(CelebrityRelative::class, 'celebrity_id', 'id')
            ->whereIn('relation_type', [CelebrityRelative::GRANDPARENTS, CelebrityRelative::GRANDFATHER, CelebrityRelative::GRANDMOTHER]);
    }

    /**
     * @return HasMany|CelebrityRelative[]
     */
    public function otherRelatives(): HasMany|array
    {
        return $this->hasMany(CelebrityRelative::class, 'celebrity_id', 'id')
            ->whereNotIn('relation_type', [
                CelebrityRelative::SPOUSE, CelebrityRelative::HUSBAND, CelebrityRelative::WIFE,
                CelebrityRelative::PARENTS, CelebrityRelative::FATHER, CelebrityRelative::MOTHER,
                CelebrityRelative::CHILDREN, CelebrityRelative::SON, CelebrityRelative::DAUGHTER,
            ]);
    }

    /**
     * @return HasMany|Trademark[]
     */
    public function trademarks(): HasMany|array
    {
        return $this->hasMany(Trademark::class, 'celebrity_id', 'id')->orderBy('sort');
    }

    /**
     * @return HasMany|Trivia[]
     */
    public function trivia(): HasMany|array
    {
        return $this->hasMany(Trivia::class, 'celebrity_id', 'id')->orderBy('sort');
    }

    /**
     * @return HasMany|Quote[]
     */
    public function quotes(): HasMany|array
    {
        return $this->hasMany(Quote::class, 'celebrity_id', 'id')->orderBy('sort');
    }

    public function livePlace(): BelongsTo|CountryRegion
    {
        return $this->belongsTo(CountryRegion::class, 'live_place', 'id');
    }

    public function birthPlace(): BelongsTo|CountryRegion
    {
        return $this->belongsTo(CountryRegion::class, 'birth_place', 'id');
    }

    public function deathPlace(): BelongsTo|CountryRegion
    {
        return $this->belongsTo(CountryRegion::class, 'death_place', 'id');
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
