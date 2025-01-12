<?php

namespace App\Models\Film;

use App\Models\BasePivot;
use App\Models\CountryRegion;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $film_id
 * @property int $country_id
 * @property int $sort
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Film $film
 * @property CountryRegion $country
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmCountry extends BasePivot
{
    protected $table = 'film_film_countries';

    protected $foreignKey = 'film_id';
    protected $relatedKey = 'country_id';

    protected bool $hasContributors = true;

    protected $fillable = [
        'film_id', 'country_id', 'sort',
    ];

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isCountryIdEqualTo(int $countryId): bool
    {
        return $this->country_id === $countryId;
    }


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
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
