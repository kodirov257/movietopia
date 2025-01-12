<?php

namespace App\Models\Film;

use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\CountryRegion;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property int $country_id
 * @property Carbon $release_date
 * @property string $details_uz
 * @property string $details_uz_cy
 * @property string $details_ru
 * @property string $details_en
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $details
 * @property Film $film
 * @property CountryRegion $country
 * @property FilmCompany $filmCompany
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmReleaseDate extends BaseModel
{
    protected $table = 'film_film_release_dates';

    protected $fillable = [
        'model_type', 'model_id', 'country_id', 'details_uz', 'details_uz_cy', 'details_ru', 'details_en', 'sort',
    ];

    protected $casts = [
        'release_date' => 'date',
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

    public function getDetailsAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getDetails($this));
    }

    ###########################################


    ########################################### Relations

    public function model(): MorphTo
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    public function country(): BelongsTo|CountryRegion
    {
        return $this->belongsTo(CountryRegion::class, 'country_id', 'id');
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
