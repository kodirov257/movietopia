<?php

namespace App\Http\Resources\Search;

use App\Entity\Meta;
use App\Models\Celebrity\CelebrityRelative;
use App\Models\Celebrity\Quote;
use App\Models\Celebrity\Trademark;
use App\Models\Celebrity\Trivia;
use App\Models\CountryRegion;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

/**
 * @property int $id
 * @property string $first_name_uz
 * @property string $first_name_uz_cy
 * @property string $first_name_ru
 * @property string $first_name_en
 * @property string $last_name_uz
 * @property string $last_name_uz_cy
 * @property string $last_name_ru
 * @property string $last_name_en
 * @property string $middle_name_uz
 * @property string $middle_name_uz_cy
 * @property string $middle_name_ru
 * @property string $middle_name_en
 * @property string $photo
 * @property string[] $professions_uz
 * @property string[] $professions_uz_cy
 * @property string[] $professions_ru
 * @property string[] $professions_en
 * @property string $biography_uz
 * @property string $biography_uz_cy
 * @property string $biography_ru
 * @property string $biography_en
 * @property int $live_place
 * @property string $original_name
 * @property string $birth_name
 * @property string[] $nicknames
 * @property Carbon $birth_date
 * @property int $birth_place
 * @property Carbon $death_date
 * @property int $death_place
 * @property string $gender
 * @property float $height_foot
 * @property float $height_meter
 * @property string $twitter
 * @property string $facebook
 * @property string $instagram
 * @property string $google_plus
 * @property string $youtube
 * @property string $linkedin
 * @property string $slug
 * @property Meta $meta_json
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $middleName
 * @property string $fullName
 * @property string $professions
 * @property string $height
 * @property string $biography
 * @property string $photoThumbnail
 * @property string $photoCustom
 * @property string $photoOriginal
 *
 * @property CelebrityRelative[] $relatives
 * @property CelebrityRelative[] $spouses
 * @property CelebrityRelative[] $parents
 * @property CelebrityRelative[] $children
 * @property CelebrityRelative[] $grandparents
 * @property CountryRegion $livePlace
 * @property CountryRegion $birthPlace
 * @property CountryRegion $deathPlace
 * @property Trademark[] $trademarks
 * @property Trivia[] $trivia
 * @property Quote[] $quotes
 * @property User $createdBy
 * @property User $updatedBy
 */
class CelebritySearchResource extends JsonResource
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
            'full_name' => $this->fullName,
            'photo_url' => $this->photo ? URL::to('/') . $this->photoCustom : null,
        ];
    }
}
