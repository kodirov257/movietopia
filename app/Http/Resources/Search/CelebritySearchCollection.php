<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CelebritySearchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        /*return [
            'celebrities' => CelebritySearchResource::collection($this),
        ];*/

        return CelebritySearchResource::collection($this)->toArray($request);
    }
}
