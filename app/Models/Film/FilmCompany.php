<?php

namespace App\Models\Film;

use App\Enums\FilmCompanyType;
use App\Helpers\LanguageHelper;
use App\Models\BaseModel;
use App\Models\Company;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property int $film_id
 * @property int $company_id
 * @property FilmCompanyType $type
 * @property string $details_uz
 * @property string $details_uz_cy
 * @property string $details_ru
 * @property string $details_en
 * @property int $sort
 * @property Carbon $date
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Film $film
 * @property Company $company
 * @property FilmReleaseDate[] $releaseDates
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmCompany extends BaseModel
{
    protected $table = 'film_film_companies';

    protected $fillable = [
        'film_id', 'company_id', 'type', 'details_uz', 'details_uz_cy', 'details_ru', 'details_en', 'sort', 'date',
    ];

    protected $casts = [
        'date' => 'date',
        'type' => FilmCompanyType::class,
    ];

    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    public function isCompanyIdEqualTo(int $companyId): bool
    {
        return $this->company_id === $companyId;
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

    public function company(): BelongsTo|Company
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return MorphMany|FilmReleaseDate[]
     */
    public function releaseDates(): MorphMany|array
    {
        return $this->morphMany(FilmReleaseDate::class, 'model')->orderBy('sort');
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
