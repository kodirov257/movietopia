<?php

namespace App\Models;

use App\Casts\MetaJson;
use App\Entity\Meta;
use App\Helpers\LanguageHelper;
use App\Models\User\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name_uz
 * @property string $name_uz_cy
 * @property string $name_ru
 * @property string $name_en
 * @property int $parent_id
 * @property string $type
 * @property string $slug
 * @property Meta $meta_json
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property CountryRegion $parent
 * @property CountryRegion[] $children
 * @property CountryRegion[] $states
 * @property CountryRegion[] $regions
 * @property CountryRegion[] $cities
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @property string $name
 * @property string $place
 *
 * @method Builder|self countries()
 * @mixin Eloquent
 */
class CountryRegion extends BaseModel
{
    use HasFactory, Sluggable;

    public const COUNTRY = 'country';
    public const STATE = 'state';
    public const REGION = 'region';
    public const CITY = 'city';

    protected $table = 'countries_regions';

    protected $fillable = ['name_uz', 'name_uz_cy', 'name_ru', 'name_en', 'parent_id', 'type', 'slug', 'meta_json'];

    protected $casts = [
        'meta_json' => MetaJson::class,
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name_en',
            ],
        ];
    }

    public static function typeList(): array
    {
        return [
            self::COUNTRY => trans('adminlte.country_region.country'),
            self::STATE => trans('adminlte.country_region.state'),
            self::REGION => trans('adminlte.country_region.region'),
            self::CITY => trans('adminlte.country_region.city'),
        ];
    }

    public function typeName(): string
    {
        return self::typeList()[$this->type];
    }

    public function getPath(): string
    {
        return ($this->parent ? $this->parent->getPath() . '/' : '') . $this->slug;
    }

    public function getAddress(): string
    {
        return ($this->parent ? $this->parent->getAddress() . ', ' : '') . $this->name;
    }

    public function getPlace(): string
    {
        return $this->name . ($this->parent ? ', ' . $this->parent->getPlace() : '');
    }


    ########################################### Mutators

    public function getNameAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getName($this));
    }

    public function getPlaceAttribute(): string
    {
        return $this->getPlace();
    }

    ###########################################


    ########################################### Scopes

    public function scopeCountries(Builder $query): Builder|self
    {
        return $query->where('parent_id', null);
    }

    ###########################################


    ########################################### Relations

    /**
     * @return BelongsTo|self[]
     */
    public function parent(): BelongsTo|array
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany|self[]
     */
    public function children(): HasMany|array
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany|self[]
     */
    public function states(): HasMany|array
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('type', self::STATE);
    }

    /**
     * @return HasMany|self[]
     */
    public function regions(): HasMany|array
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('type', self::REGION);
    }

    /**
     * @return HasMany|self[]
     */
    public function cities(): HasMany|array
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('type', self::CITY);
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
