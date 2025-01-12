<?php

namespace App\Models\Film;

use App\Models\BasePivot;
use App\Models\Language;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $film_id
 * @property int $language_id
 * @property string $title
 * @property bool $main
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Film $film
 * @property Language $language
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmTitle extends BasePivot
{
    protected $table = 'film_film_titles';

    protected $foreignKey = 'film_id';
    protected $relatedKey = 'language_id';

    protected $fillable = [
        'film_id', 'language_id', 'title', 'main',
    ];

    protected $casts = [
        'main' => 'boolean',
    ];

    protected bool $hasContributors = true;


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function language(): BelongsTo|Language
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
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
