<?php

namespace App\Http\Controllers\Api;

use App\Helpers\LanguageHelper;
use App\Http\Resources\Search\CelebritySearchCollection;
use App\Http\Resources\Search\FilmSearchCollection;
use App\Http\Resources\Search\RegionSearchCollection;
use App\Models\Celebrity\Celebrity;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    public function searchRegions(Request $request): JsonResponse
    {
        try {
            if (!empty($value = $request->get('name'))) {
                $regions = CountryRegion::where(function ($query) use ($value) {
                    $query->where('name_uz', 'ilike', '%' . $value . '%')
                        ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                        ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                        ->orWhere('name_en', 'ilike', '%' . $value . '%')
                        ->orWhere('slug', 'ilike', '%' . $value . '%');
                })->whereIn('type', [CountryRegion::REGION, CountryRegion::STATE, CountryRegion::CITY])
                    ->orderByDesc('type')
                    ->orderByDesc('name_' . LanguageHelper::getCurrentLanguagePrefix())->paginate(10);
            } else {
                $regions = CountryRegion::orderByDesc('type')
                    ->orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix())
                    ->whereIn('type', [CountryRegion::REGION, CountryRegion::STATE, CountryRegion::CITY])->paginate(10);
            }

            $totalLength = $regions->total();
            $regionCollection = (new RegionSearchCollection($regions))->toArray($request);

            if ($regions->isEmpty() || $regions->count() < 10) {
                if (!empty($value = $request->get('name'))) {
                    $countries = CountryRegion::where(function ($query) use ($value) {
                        $query->where('name_uz', 'ilike', '%' . $value . '%')
                            ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                            ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                            ->orWhere('name_en', 'ilike', '%' . $value . '%')
                            ->orWhere('slug', 'ilike', '%' . $value . '%');
                    })->where('type', [CountryRegion::COUNTRY])
                        ->orderByDesc('type')
                        ->orderByDesc('name_' . LanguageHelper::getCurrentLanguagePrefix())->paginate(10);
                } else {
                    $countries = CountryRegion::orderByDesc('type')
                        ->orderBy('name_' . LanguageHelper::getCurrentLanguagePrefix())
                        ->where('type', [CountryRegion::COUNTRY])->paginate(10);
                }

                $totalLength = max($countries->total(), $totalLength);
                $countryCollection = (new RegionSearchCollection($countries))->toArray($request);
                $regionCollection = array_merge($regionCollection, $countryCollection);
            }

            return $this->sendResponse(['regions' => $regionCollection, 'total' => $totalLength]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }

    public function searchCelebrities(Request $request): JsonResponse
    {
        try {
            $langPrefix = LanguageHelper::getCurrentLanguagePrefix();
            if (!empty($value = $request->get('name'))) {
                $celebrities = Celebrity::where(function (Builder $query) use ($value) {
                    $query->whereRaw("CONCAT_WS(' ', first_name_uz, last_name_uz) ILIKE '%{$value}%'")
                        ->orWhereRaw("CONCAT_WS(' ', first_name_uz_cy, last_name_uz_cy) ILIKE '%{$value}%'")
                        ->orWhereRaw("CONCAT_WS(' ', first_name_ru, last_name_ru) ILIKE '%{$value}%'")
                        ->orWhereRaw("CONCAT_WS(' ', first_name_en, last_name_en) ILIKE '%{$value}%'");
                })->orderBy('first_name_' . $langPrefix)
                    ->orderBy('last_name_' . $langPrefix)->paginate(10);
            } else {
                $celebrities = Celebrity::orderBy('first_name_' . $langPrefix)
                    ->orderBy('last_name_' . $langPrefix)->paginate(10);
            }

            $totalLength = $celebrities->total();
            $celebrityCollection = (new CelebritySearchCollection($celebrities))->toArray($request);

            return $this->sendResponse(['celebrities' => $celebrityCollection, 'total' => $totalLength]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }

    public function searchFilms(Request $request): JsonResponse
    {
        try {
            $langPrefix = LanguageHelper::getCurrentLanguagePrefix();
            if (!empty($value = $request->get('title'))) {
                $films = Film::where(function (Builder $query) use ($value) {
                    $query->where('title_uz', 'ilike', '%' . $value . '%')
                        ->orWhere('title_uz_cy', 'ilike', '%' . $value . '%')
                        ->orWhere('title_ru', 'ilike', '%' . $value . '%')
                        ->orWhere('title_en', 'ilike', '%' . $value . '%');
                })->orderBy('title_' . $langPrefix)->paginate(10);
            } else {
                $films = Film::orderBy('title_' . $langPrefix)->paginate(10);
            }

            $totalLength = $films->total();
            $filmCollection = (new FilmSearchCollection($films))->toArray($request);

            return $this->sendResponse(['films' => $filmCollection, 'total' => $totalLength]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }
}
