<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class LanguageHelper
{
    public const UZBEK = 'uz';
    public const UZBEK_CYRILLIC = 'uz_cy';
    public const RUSSIAN = 'ru';
    public const ENGLISH = 'en';

    public static function getName($className, $lang = null): string
    {
        return self::getAttribute($className, 'name', $lang) ?? '';
    }

    public static function getFirstName($className, $lang = null): string
    {
        return self::getAttribute($className, 'first_name', $lang) ?? '';
    }

    public static function getMiddleName($className, $lang = null): string
    {
        return self::getAttribute($className, 'middle_name', $lang) ?? '';
    }

    public static function getLastName($className, $lang = null): string
    {
        return self::getAttribute($className, 'last_name', $lang) ?? '';
    }

    public static function getProfessions($className, $lang = null): string|array
    {
        return self::getAttribute($className, 'professions', $lang) ?? '';
    }

    public static function getBiography($className, $lang = null): string
    {
        return self::getAttribute($className, 'biography', $lang) ?? '';
    }

    public static function getTrivia($className, $lang = null): string
    {
        return self::getAttribute($className, 'trivia', $lang) ?? '';
    }

    public static function getTrademark($className, $lang = null): string
    {
        return self::getAttribute($className, 'trademark', $lang) ?? '';
    }

    public static function getQuote($className, $lang = null): string
    {
        return self::getAttribute($className, 'quote', $lang) ?? '';
    }

    public static function getAttribute($className, string $attributeName, $lang = null): string|array|null
    {
        if ($lang) {
            $attribute = $attributeName . '_' . $lang;
        } else {
            $attribute = $attributeName . '_' . self::getCurrentLanguagePrefix();
        }

        if ($className->$attribute) {
            return $className->$attribute;
        }

        return $className->{$attributeName . '_' . self::UZBEK} ?:
            $className->{$attributeName . '_' . self::UZBEK_CYRILLIC} ?:
            $className->{$attributeName . '_' . self::RUSSIAN} ?:
                $className->{$attributeName . '_' . self::ENGLISH};
    }

    public static function getCurrentLanguagePrefix(): string
    {
        if (str_starts_with(App::getLocale(), self::UZBEK_CYRILLIC)) {
            return self::UZBEK_CYRILLIC;
        }

        return mb_substr(App::getLocale(), 0, 2);
    }

    public static function getPrefix($lang): string
    {
        return match ($lang) {
            self::UZBEK => self::UZBEK,
            self::UZBEK_CYRILLIC => self::UZBEK_CYRILLIC,
            self::RUSSIAN => self::RUSSIAN,
            self::ENGLISH => self::ENGLISH,
            default => self::getCurrentLanguagePrefix(),
        };
    }
}
