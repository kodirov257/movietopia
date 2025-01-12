<?php

namespace App\Models;

use App\Helpers\LanguageHelper;
use App\Models\Film\Film;
use App\Models\Film\FilmLanguage;
use App\Models\User\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name_uz
 * @property string $name_uz_cy
 * @property string $name_ru
 * @property string $name_en
 * @property string $slug
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property FilmLanguage[] $languageFilms
 * @property Film[] $films
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @property string $name
 *
 * @mixin Eloquent
 */
class Language extends BaseModel
{
    use HasFactory, Sluggable;

    protected $table = 'languages';

    protected $fillable = ['name_uz', 'name_uz_cy', 'name_ru', 'name_en', 'slug'];

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

    ###########################################


    ########################################### Relations

    public function languageFilms(): HasMany|FilmLanguage
    {
        return $this->hasMany(FilmLanguage::class, 'language_id', 'id');
    }

    public function films(): BelongsToMany|Film
    {
        return $this->belongsToMany(Film::class, 'film_film_languages', 'language_id', 'film_id')
            ->withPivot('sort', 'created_by', 'updated_by')->withTimestamps();
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
