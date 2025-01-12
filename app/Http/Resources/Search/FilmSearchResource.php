<?php

namespace App\Http\Resources\Search;

use App\Entity\Meta;
use App\Models\Company;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmAlternateVersion;
use App\Models\Film\FilmCompany;
use App\Models\Film\FilmConnection;
use App\Models\Film\FilmCountry;
use App\Models\Film\FilmCredit;
use App\Models\Film\FilmGenre;
use App\Models\Film\FilmGoof;
use App\Models\Film\FilmLanguage;
use App\Models\Film\FilmLocation;
use App\Models\Film\FilmReleaseDate;
use App\Models\Film\FilmSlogan;
use App\Models\Film\FilmStoryline;
use App\Models\Film\FilmSynopsis;
use App\Models\Film\FilmTitle;
use App\Models\Film\FilmTrivia;
use App\Models\Film\FilmType;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Type;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title_uz
 * @property string $title_uz_cy
 * @property string $title_ru
 * @property string $title_en
 * @property string $original_title
 * @property string $description_uz
 * @property string $description_uz_cy
 * @property string $description_ru
 * @property string $description_en
 * @property string $slug
 * @property bool $tv_series
 * @property int $status
 * @property string $poster
 * @property int $age_rating
 * @property float $film_rating
 * @property int $film_rating_number
 * @property int $duration_minutes
 * @property Carbon $world_released_at
 * @property Carbon $last_season_released_at
 * @property Carbon $last_episode_released_at
 * @property bool $budget_estimated
 * @property string $budget_from
 * @property string $budget_to
 * @property string $box_office_local
 * @property string $box_office_worldwide
 * @property Carbon $filming_date_from
 * @property Carbon $filming_date_to
 * @property array $sites
 * @property float $imdb_rating
 * @property int $imdb_rating_voting
 * @property Meta $meta_json
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $title
 * @property string $description
 * @property string $posterThumbnail
 * @property string $posterCustom
 * @property string $posterOriginal
 *
 * @property FilmSlogan[] $slogans
 * @property FilmSynopsis[] $synopses
 * @property FilmStoryline[] $storylines
 * @property FilmTrivia[] $trivias
 * @property FilmGoof[] $goofs
 * @property FilmCredit[] $credits
 * @property FilmConnection[] $filmConnections
 * @property Film[] $connectedFilms
 * @property FilmTitle[] $titles
 * @property FilmCountry[] $filmCountries
 * @property CountryRegion[] $countries
 * @property FilmLanguage[] $filmLanguages
 * @property Language[] $languages
 * @property FilmLocation[] $filmLocations
 * @property CountryRegion[] $locations
 * @property FilmCompany[] $filmCompanies
 * @property FilmReleaseDate[] $releaseDates
 * @property Company[] $companies
 * @property FilmGenre[] $filmGenres
 * @property Genre[] $genres
 * @property FilmType[] $filmTypes
 * @property Type[] $types
 * @property FilmAlternateVersion[] $alternateVersions
 * @property User $createdBy
 * @property User $updatedBy
 */
class FilmSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
        ];
    }
}
