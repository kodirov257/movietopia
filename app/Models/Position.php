<?php

namespace App\Models;

use App\Casts\MetaJson;
use App\Entity\Meta;
use App\Helpers\LanguageHelper;
use App\Models\User\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name_uz
 * @property string $name_uz_cy
 * @property string $name_ru
 * @property string $name_en
 * @property string $slug
 * @property Meta $meta_json
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @property string $name
 * @property string $nameLow
 *
 * @mixin Eloquent
 */
class Position extends BaseModel
{
    use HasFactory, Sluggable;

    protected $table = 'positions';

    protected $fillable = ['name_uz', 'name_uz_cy', 'name_ru', 'name_en', 'slug', 'meta_json'];

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


    ########################################### Mutators

    public function getNameAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getName($this));
    }

    public function getNameLowAttribute(): string
    {
        return htmlspecialchars_decode(strtolower(LanguageHelper::getName($this)));
    }

    ###########################################


    ########################################### Relations

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
