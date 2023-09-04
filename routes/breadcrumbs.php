<?php

use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\CelebrityRelative;
use App\Models\Celebrity\Quote;
use App\Models\Celebrity\Trademark;
use App\Models\Celebrity\Trivia;
use App\Models\Company;
use App\Models\CountryRegion;
use App\Models\Genre;
use App\Models\Position;
use App\Models\User\User;
use Diglactic\Breadcrumbs\Generator as Crumbs;

Breadcrumbs::for('home', function (Crumbs $crumbs) {
    $crumbs->push(trans('adminlte.home'), route('home'));
});

Breadcrumbs::for('login', function (Crumbs $crumbs) {
});


################################### Admin

Breadcrumbs::for('dashboard.home', function (Crumbs $crumbs) {
    $crumbs->push(trans('adminlte.home'), route('dashboard.home'));
});

// Users

Breadcrumbs::for('dashboard.users.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.users'), route('dashboard.users.index'));
});

Breadcrumbs::for('dashboard.users.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.users.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.users.create'));
});

Breadcrumbs::for('dashboard.users.show', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('dashboard.users.index');
    $crumbs->push($user->name, route('dashboard.users.show', $user));
});

Breadcrumbs::for('dashboard.users.edit', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('dashboard.users.show', $user);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.users.edit', $user));
});


// Genres

Breadcrumbs::for('dashboard.genres.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.genres'), route('dashboard.genres.index'));
});

Breadcrumbs::for('dashboard.genres.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.genres.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.genres.create'));
});

Breadcrumbs::for('dashboard.genres.show', function (Crumbs $crumbs, Genre $genre) {
    $crumbs->parent('dashboard.genres.index');
    $crumbs->push($genre->name, route('dashboard.genres.show', $genre));
});

Breadcrumbs::for('dashboard.genres.edit', function (Crumbs $crumbs, Genre $genre) {
    $crumbs->parent('dashboard.genres.show', $genre);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.genres.edit', $genre));
});


// Countries and Regions

Breadcrumbs::for('dashboard.country-regions.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.countries'), route('dashboard.country-regions.index'));
});

Breadcrumbs::for('dashboard.country-regions.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.country-regions.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.country-regions.create'));
});

Breadcrumbs::for('dashboard.country-regions.show', function (Crumbs $crumbs, CountryRegion $countryRegion) {
    if ($parent = $countryRegion->parent) {
        $crumbs->parent('dashboard.country-regions.show', $parent);
    } else {
        $crumbs->parent('dashboard.country-regions.index');
    }
    $crumbs->push($countryRegion->name, route('dashboard.country-regions.show', $countryRegion));
});

Breadcrumbs::for('dashboard.country-regions.edit', function (Crumbs $crumbs, CountryRegion $countryRegion) {
    $crumbs->parent('dashboard.country-regions.show', $countryRegion);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.country-regions.edit', $countryRegion));
});


// Companies

Breadcrumbs::for('dashboard.companies.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.companies'), route('dashboard.companies.index'));
});

Breadcrumbs::for('dashboard.companies.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.companies.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.companies.create'));
});

Breadcrumbs::for('dashboard.companies.show', function (Crumbs $crumbs, Company $company) {
    $crumbs->parent('dashboard.companies.index');
    $crumbs->push($company->name, route('dashboard.companies.show', $company));
});

Breadcrumbs::for('dashboard.companies.edit', function (Crumbs $crumbs, Company $company) {
    $crumbs->parent('dashboard.companies.show', $company);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.companies.edit', $company));
});


// Positions

Breadcrumbs::for('dashboard.positions.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.positions'), route('dashboard.positions.index'));
});

Breadcrumbs::for('dashboard.positions.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.positions.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.positions.create'));
});

Breadcrumbs::for('dashboard.positions.show', function (Crumbs $crumbs, Position $position) {
    $crumbs->parent('dashboard.positions.index');
    $crumbs->push($position->name, route('dashboard.positions.show', $position));
});

Breadcrumbs::for('dashboard.positions.edit', function (Crumbs $crumbs, Position $position) {
    $crumbs->parent('dashboard.positions.show', $position);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.positions.edit', $position));
});


// Celebrities

Breadcrumbs::for('dashboard.celebrities.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.celebrities'), route('dashboard.celebrities.index'));
});

Breadcrumbs::for('dashboard.celebrities.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.celebrities.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.celebrities.create'));
});

Breadcrumbs::for('dashboard.celebrities.show', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.index');
    $crumbs->push($celebrity->fullName, route('dashboard.celebrities.show', $celebrity));
});

Breadcrumbs::for('dashboard.celebrities.edit', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.show', $celebrity);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.celebrities.edit', $celebrity));
});

Breadcrumbs::for('dashboard.celebrities.biography.edit', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.show', $celebrity);
    $crumbs->push(trans('adminlte.celebrity.edit_biography'), route('dashboard.celebrities.biography.edit', $celebrity));
});

// Celebrity Relatives

Breadcrumbs::for('dashboard.celebrities.relatives.index', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.show', $celebrity);
    $crumbs->push(trans('menu.celebrity_relatives'));
});

Breadcrumbs::for('dashboard.celebrities.relatives.create', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.relatives.index', $celebrity);
    $crumbs->push(trans('adminlte.create'), route('dashboard.celebrities.relatives.create', $celebrity));
});

Breadcrumbs::for('dashboard.celebrities.relatives.show', function (Crumbs $crumbs, Celebrity $celebrity, CelebrityRelative $relative) {
    $crumbs->parent('dashboard.celebrities.relatives.index', $celebrity);
    $crumbs->push($relative->id, route('dashboard.celebrities.relatives.show', ['celebrity' => $celebrity, 'relative' => $relative]));
});

Breadcrumbs::for('dashboard.celebrities.relatives.edit', function (Crumbs $crumbs, Celebrity $celebrity, CelebrityRelative $relative) {
    $crumbs->parent('dashboard.celebrities.relatives.show', $celebrity, $relative);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.celebrities.relatives.edit', ['celebrity' => $celebrity, 'relative' => $relative]));
});

// Trademarks

Breadcrumbs::for('dashboard.celebrities.trademarks.index', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.show', $celebrity);
    $crumbs->push(trans('menu.trademarks'));
});

Breadcrumbs::for('dashboard.celebrities.trademarks.create', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.trademarks.index', $celebrity);
    $crumbs->push(trans('adminlte.create'), route('dashboard.celebrities.trademarks.create', $celebrity));
});

Breadcrumbs::for('dashboard.celebrities.trademarks.show', function (Crumbs $crumbs, Celebrity $celebrity, Trademark $trademark) {
    $crumbs->parent('dashboard.celebrities.trademarks.index', $celebrity);
    $crumbs->push($trademark->id, route('dashboard.celebrities.trademarks.show', ['celebrity' => $celebrity, 'trademark' => $trademark]));
});

Breadcrumbs::for('dashboard.celebrities.trademarks.edit', function (Crumbs $crumbs, Celebrity $celebrity, Trademark $trademark) {
    $crumbs->parent('dashboard.celebrities.trademarks.show', $celebrity, $trademark);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.celebrities.trademarks.edit', ['celebrity' => $celebrity, 'trademark' => $trademark]));
});

// Trivia

Breadcrumbs::for('dashboard.celebrities.trivias.index', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.show', $celebrity);
    $crumbs->push(trans('menu.trivias'));
});

Breadcrumbs::for('dashboard.celebrities.trivias.create', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.trivias.index', $celebrity);
    $crumbs->push(trans('adminlte.create'), route('dashboard.celebrities.trivias.create', $celebrity));
});

Breadcrumbs::for('dashboard.celebrities.trivias.show', function (Crumbs $crumbs, Celebrity $celebrity, Trivia $trivia) {
    $crumbs->parent('dashboard.celebrities.trivias.index', $celebrity);
    $crumbs->push($trivia->id, route('dashboard.celebrities.trivias.show', ['celebrity' => $celebrity, 'trivia' => $trivia]));
});

Breadcrumbs::for('dashboard.celebrities.trivias.edit', function (Crumbs $crumbs, Celebrity $celebrity, Trivia $trivia) {
    $crumbs->parent('dashboard.celebrities.trivias.show', $celebrity, $trivia);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.celebrities.trivias.edit', ['celebrity' => $celebrity, 'trivia' => $trivia]));
});

// Quotes

Breadcrumbs::for('dashboard.celebrities.quotes.index', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.show', $celebrity);
    $crumbs->push(trans('menu.quotes'));
});

Breadcrumbs::for('dashboard.celebrities.quotes.create', function (Crumbs $crumbs, Celebrity $celebrity) {
    $crumbs->parent('dashboard.celebrities.quotes.index', $celebrity);
    $crumbs->push(trans('adminlte.create'), route('dashboard.celebrities.quotes.create', $celebrity));
});

Breadcrumbs::for('dashboard.celebrities.quotes.show', function (Crumbs $crumbs, Celebrity $celebrity, Quote $quote) {
    $crumbs->parent('dashboard.celebrities.quotes.index', $celebrity);
    $crumbs->push($quote->id, route('dashboard.celebrities.quotes.show', ['celebrity' => $celebrity, 'quote' => $quote]));
});

Breadcrumbs::for('dashboard.celebrities.quotes.edit', function (Crumbs $crumbs, Celebrity $celebrity, Quote $quote) {
    $crumbs->parent('dashboard.celebrities.quotes.show', $celebrity, $quote);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.celebrities.quotes.edit', ['celebrity' => $celebrity, 'quote' => $quote]));
});
