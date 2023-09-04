<?php

namespace App\Casts;

use App\Entity\Meta;
use App\Models\Celebrity\Celebrity;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class MetaJson implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Meta
     * @throws \JsonException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Meta
    {
        $metaInfoArray = json_decode($value, true, 512, JSON_THROW_ON_ERROR) ;
        if ($model instanceof Celebrity) {
            $title = $model->fullName;
        } else {
            $title = $model->name_en ?? $model->title_en;
        }
        return new Meta(
            isset($metaInfoArray['title']) && !empty($metaInfoArray['title']) ? $metaInfoArray['title'] : $title,
            isset($metaInfoArray['keywords']) && !empty($metaInfoArray['keywords']) ? $metaInfoArray['keywords'] : implode(', ', array_merge([$title])),
            isset($metaInfoArray['description']) && !empty($metaInfoArray['description']) ? $metaInfoArray['description'] : ''
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return string
     * @throws \JsonException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (!$value instanceof Meta) {
            throw new InvalidArgumentException('The given value is not an Meta instance.');
        }
        return json_encode($value->toArray(), JSON_THROW_ON_ERROR);
    }
}
