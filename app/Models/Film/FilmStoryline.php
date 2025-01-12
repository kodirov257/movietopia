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
 * @property string $storyline_uz
 * @property string $storyline_uz_cy
 * @property string $storyline_ru
 * @property string $storyline_en
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $storyline
 * @property Film $film
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmStoryline extends BaseModel
{
    protected $table = 'film_film_storylines';

    protected $fillable = [
        'film_id', 'storyline_uz', 'storyline_uz_cy', 'storyline_ru', 'storyline_en', 'sort',
    ];

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo(int $id): bool
    {
        return $this->id === $id;
    }


    ########################################### Mutators

    public function getStorylineAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getAttribute($this, 'storyline'));
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
