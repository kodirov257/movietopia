<?php

if (! function_exists('custom_substr')) {

    function custom_substr(string $string, int $length = 200): string
    {
        $stringWithoutTags = strip_tags($string);

        if (strlen($stringWithoutTags) <= $length) {
            return $stringWithoutTags;
        }

        return substr($stringWithoutTags, 0, $length) . '...';
    }
}
