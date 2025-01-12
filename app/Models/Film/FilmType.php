<?php

namespace App\Models\Film;

use App\Models\BasePivot;
use App\Models\Type;
use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $film_id
 * @property int $type_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Film $film
 * @property Type $type
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @mixin Eloquent
 */
class FilmType extends BasePivot
{
    protected $table = 'film_film_types';

    protected $foreignKey = 'film_id';
    protected $relatedKey = 'type_id';

    public $timestamps = false;

    protected $fillable = [
        'film_id', 'type_id',
    ];


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function type(): BelongsTo|Type
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
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
