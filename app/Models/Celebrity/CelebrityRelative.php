<?php

namespace App\Models\Celebrity;

use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $celebrity_id
 * @property int $relative_id
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
 * @property string $relation_type
 * @property Carbon $marry_date
 * @property Carbon $divorce_date
 * @property boolean $divorce_reason
 * @property int $children
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $fullName
 *
 * @property Celebrity $celebrity
 * @property Celebrity $relative
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class CelebrityRelative extends BaseModel
{
    public const SPOUSE = 'spouse';
    public const WIFE = 'wife';
    public const HUSBAND = 'husband';
    public const CHILDREN = 'children';
    public const SON = 'son';
    public const DAUGHTER = 'daughter';
    public const PARENTS = 'parents';
    public const FATHER = 'father';
    public const MOTHER = 'mother';
    public const GRANDPARENTS = 'grandparents';
    public const GRANDFATHER = 'grandfather';
    public const GRANDMOTHER = 'grandmother';
    public const GRANDCHILDREN = 'grandchildren';
    public const GRANDSON = 'grandson';
    public const GRANDDAUGHTER = 'granddaughter';
    public const SIBLING = 'sibling';
    public const BROTHER = 'brother';
    public const SISTER = 'sister';
    public const HALF_SIBLING = 'half_sibling';
    public const HALF_BROTHER = 'half_brother';
    public const HALF_SISTER = 'half_sister';
    public const UNCLE_OR_AUNT = 'uncle_or_aunt';
    public const UNCLE = 'uncle';
    public const AUNT = 'aunt';
    public const NEPHEW_OR_NIECE = 'nephew_or_niece';
    public const NEPHEW = 'nephew';
    public const NIECE = 'niece';
    public const COUSIN = 'cousin';
    public const DESCENDANT = 'descendant';
    public const ANCESTOR = 'ancestor';

    public const OWN_DEATH = 'own_death';
    public const SPOUSE_DEATH = 'spouse_death';

    protected $table = 'celebrity_relatives';

    protected $fillable = [
        'celebrity_id', 'relative_id', 'first_name_uz', 'first_name_uz_cy', 'first_name_ru', 'first_name_en',
        'last_name_uz', 'last_name_uz_cy', 'last_name_ru', 'last_name_en', 'middle_name_uz', 'middle_name_uz_cy',
        'middle_name_ru', 'middle_name_en', 'relation_type', 'marry_date', 'divorce_date', 'divorce_reason', 'children',
    ];

    protected $casts = [
        'marry_date' => 'datetime',
        'divorce_date' => 'datetime',
    ];

    public static function relativeTypesList(): array
    {
        return [
            self::SPOUSE => trans('movie.relatives.spouse'),
            self::HUSBAND => trans('movie.relatives.husband'),
            self::WIFE => trans('movie.relatives.wife'),
            self::SON => trans('movie.relatives.son'),
            self::DAUGHTER => trans('movie.relatives.daughter'),
            self::FATHER => trans('movie.relatives.father'),
            self::MOTHER => trans('movie.relatives.mother'),
            self::GRANDFATHER => trans('movie.relatives.grandfather'),
            self::GRANDMOTHER => trans('movie.relatives.grandmother'),
            self::GRANDSON => trans('movie.relatives.grandfather'),
            self::GRANDDAUGHTER => trans('movie.relatives.grandmother'),
            self::BROTHER => trans('movie.relatives.brother'),
            self::SISTER => trans('movie.relatives.sister'),
            self::HALF_BROTHER => trans('movie.relatives.half_brother'),
            self::HALF_SISTER => trans('movie.relatives.half_sister'),
            self::AUNT => trans('movie.relatives.aunt'),
            self::UNCLE => trans('movie.relatives.uncle'),
            self::NEPHEW => trans('movie.relatives.nephew'),
            self::NIECE => trans('movie.relatives.niece'),
            self::COUSIN => trans('movie.relatives.cousin'),
            self::DESCENDANT => trans('movie.relatives.descendant'),
            self::ANCESTOR => trans('movie.relatives.ancestor'),
        ];
    }

    public static function spousesTypesList(): array
    {
        return [
            self::SPOUSE => trans('movie.relatives.spouse'),
            self::HUSBAND => trans('movie.relatives.husband'),
            self::WIFE => trans('movie.relatives.wife'),
        ];
    }

    public function relativeTypeName(): string
    {
        return self::relativeTypesList()[$this->relation_type];
    }

    public static function divorceReasonList(): array
    {
        return [
            self::OWN_DEATH => trans('adminlte.celebrity.own_death'),
            self::SPOUSE_DEATH => trans('adminlte.celebrity.spouse_death'),
        ];
    }

    public function divorceReasonName(): string
    {
        return self::divorceReasonList()[$this->relation_type];
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


    ########################################### Mutators

    public function getFullNameAttribute(): string
    {
        return $this->fullName();
    }

    ###########################################


    ########################################### Relations


    public function celebrity(): BelongsTo|Celebrity
    {
        return $this->belongsTo(Celebrity::class, 'celebrity_id', 'id');
    }

    public function relative(): BelongsTo|Celebrity
    {
        return $this->belongsTo(Celebrity::class, 'relative_id', 'id');
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
