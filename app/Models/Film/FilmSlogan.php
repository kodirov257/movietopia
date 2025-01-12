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
 * @property string $slogan_uz
 * @property string $slogan_uz_cy
 * @property string $slogan_ru
 * @property string $slogan_en
 * @property bool $main
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $slogan
 * @property Film $film
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmSlogan extends BaseModel
{
    protected $table = 'film_film_slogans';

    protected $fillable = [
        'film_id', 'slogan_uz', 'slogan_uz_cy', 'slogan_ru', 'slogan_en', 'main', 'sort',
    ];

    protected $casts = [
        'main' => 'boolean',
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

    public function getSloganAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getSlogan($this));
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
