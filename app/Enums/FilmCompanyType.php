<?php

declare(strict_types=1);

namespace App\Enums;

enum FilmCompanyType: string
{
    case PRODUCTION_COMPANY = 'production_company';
    case DISTRIBUTOR = 'distributor';
    case SPECIAL_EFFECTS = 'special_effects';
    case OTHER = 'other';

    public static function typesList(): array
    {
        return [
            self::PRODUCTION_COMPANY->value => __('movie.film.company.production_company'),
            self::DISTRIBUTOR->value => __('movie.film.company.distributor'),
            self::SPECIAL_EFFECTS->value => __('movie.film.company.special_effects'),
            self::OTHER->value => __('movie.film.company.other'),
        ];
    }

    public function typeName(): string
    {
        return self::typesList()[$this->value];
    }
}
