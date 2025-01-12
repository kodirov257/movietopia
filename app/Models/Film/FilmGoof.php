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
 * @property string $goof_uz
 * @property string $goof_uz_cy
 * @property string $goof_ru
 * @property string $goof_en
 * @property int $type_id
 * @property bool $spoiler
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $goof
 * @property Film $film
 * @property GoofType $type
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmGoof extends BaseModel
{
    protected $table = 'film_film_goofs';

    protected $fillable = [
        'film_id', 'goof_uz', 'goof_uz_cy', 'goof_ru', 'goof_en', 'type', 'spoiler', 'sort',
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

    public function getGoofAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getAttribute($this, 'goof'));
    }

    ###########################################


    ########################################### Relations

    public function type(): BelongsTo|GoofType
    {
        return $this->belongsTo(GoofType::class, 'type_id', 'id');
    }

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
