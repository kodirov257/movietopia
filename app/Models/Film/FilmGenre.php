<?php

namespace App\Models\Film;

use App\Models\BasePivot;
use App\Models\Genre;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $film_id
 * @property int $genre_id
 *
 * @property Film $film
 * @property Genre $genre
 *
 * @mixin Eloquent
 */
class FilmGenre extends BasePivot
{
    protected $table = 'film_film_genres';

    protected $foreignKey = 'film_id';
    protected $relatedKey = 'genre_id';

    public $timestamps = false;

    protected $fillable = [
        'film_id', 'genre_id',
    ];


    ########################################### Relations

    public function film(): BelongsTo|Film
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function genre(): BelongsTo|Genre
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }

    ###########################################
}
