<?php

namespace App\Models\Film;

use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\BasePivot;
use App\Models\CountryRegion;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $film_id
 * @property int $location_id
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
 * @property CountryRegion $location
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmLocation extends BaseModel
{
    protected $table = 'film_film_locations';

    protected $fillable = [
        'film_id', 'location_id', 'details_uz', 'details_uz_cy', 'details_ru', 'details_en', 'sort',
    ];

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isLocationIdEqualTo(int $locationId): bool
    {
        return $this->location_id === $locationId;
    }


    ########################################### Mutators

    public function getDetailsAttribute(): string
    {
        return htmlspecialchars_decode(LanguageHelper::getDetails($this));
    }

    ###########################################


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function location(): BelongsTo|CountryRegion
    {
        return $this->belongsTo(CountryRegion::class, 'location_id', 'id');
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
