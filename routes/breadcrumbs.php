<?php

use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\CelebrityRelative;
use App\Models\Celebrity\Quote;
use App\Models\Celebrity\Trademark;
use App\Models\Celebrity\Trivia;
use App\Models\Company;
use App\Models\CountryRegion;
use App\Models\Film\Film;
use App\Models\Film\FilmAlternateVersion;
use App\Models\Film\FilmCompany;
use App\Models\Film\FilmConnection;
use App\Models\Film\FilmCredit;
use App\Models\Film\FilmGoof;
use App\Models\Film\FilmLocation;
use App\Models\Film\FilmReleaseDate;
use App\Models\Film\FilmSlogan;
use App\Models\Film\FilmSynopsis;
use App\Models\Film\FilmTrivia;
use App\Models\Film\GoofType;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Position;
use App\Models\Type;
use App\Models\User\User;
use Diglactic\Breadcrumbs\Generator as Crumbs;

Breadcrumbs::for('home', function (Crumbs $crumbs) {
    $crumbs->push(trans('adminlte.home'), route('home'));
});

Breadcrumbs::for('login', function (Crumbs $crumbs) {
});

Breadcrumbs::for('register.show', function (Crumbs $crumbs) {
});

Breadcrumbs::for('password.email.request', function (Crumbs $crumbs) {
});

Breadcrumbs::for('two-factor-auth.create', function (Crumbs $crumbs) {
});

Breadcrumbs::for('two-factor-auth.store', function (Crumbs $crumbs) {
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


// Types

Breadcrumbs::for('dashboard.types.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.types'), route('dashboard.types.index'));
});

Breadcrumbs::for('dashboard.types.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.types.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.types.create'));
});

Breadcrumbs::for('dashboard.types.show', function (Crumbs $crumbs, Type $type) {
    $crumbs->parent('dashboard.types.index');
    $crumbs->push($type->name, route('dashboard.types.show', $type));
});

Breadcrumbs::for('dashboard.types.edit', function (Crumbs $crumbs, Type $type) {
    $crumbs->parent('dashboard.types.show', $type);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.types.edit', $type));
});


// Goof Types

Breadcrumbs::for('dashboard.goof-types.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.goof_types'), route('dashboard.goof-types.index'));
});

Breadcrumbs::for('dashboard.goof-types.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.goof-types.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.goof-types.create'));
});

Breadcrumbs::for('dashboard.goof-types.show', function (Crumbs $crumbs, GoofType $goofType) {
    $crumbs->parent('dashboard.goof-types.index');
    $crumbs->push($goofType->name, route('dashboard.goof-types.show', $goofType));
});

Breadcrumbs::for('dashboard.goof-types.edit', function (Crumbs $crumbs, GoofType $goofType) {
    $crumbs->parent('dashboard.goof-types.show', $goofType);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.goof-types.edit', $goofType));
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


// Languages

Breadcrumbs::for('dashboard.languages.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.languages'), route('dashboard.languages.index'));
});

Breadcrumbs::for('dashboard.languages.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.languages.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.languages.create'));
});

Breadcrumbs::for('dashboard.languages.show', function (Crumbs $crumbs, Language $language) {
    $crumbs->parent('dashboard.languages.index');
    $crumbs->push($language->name, route('dashboard.languages.show', $language));
});

Breadcrumbs::for('dashboard.languages.edit', function (Crumbs $crumbs, Language $language) {
    $crumbs->parent('dashboard.languages.show', $language);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.languages.edit', $language));
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

// Celebrity Trademarks

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

// Celebrity Trivia

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

// Celebrity Quotes

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


// Films

Breadcrumbs::for('dashboard.films.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.films'), route('dashboard.films.index'));
});

Breadcrumbs::for('dashboard.films.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.films.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.create'));
});

Breadcrumbs::for('dashboard.films.show', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.index');
    $crumbs->push($film->title, route('dashboard.films.show', $film));
});

Breadcrumbs::for('dashboard.films.edit', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.edit', $film));
});

Breadcrumbs::for('dashboard.films.description.edit', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('adminlte.film.edit_description'), route('dashboard.films.description.edit', $film));
});

Breadcrumbs::for('dashboard.films.storyline.edit', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('adminlte.film.edit_storyline'), route('dashboard.films.storyline.edit', $film));
});

// Film Slogans

Breadcrumbs::for('dashboard.films.slogans.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.slogans'));
});

Breadcrumbs::for('dashboard.films.slogans.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.slogans.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.slogans.create', $film));
});

Breadcrumbs::for('dashboard.films.slogans.show', function (Crumbs $crumbs, Film $film, FilmSlogan $slogan) {
    $crumbs->parent('dashboard.films.slogans.index', $film);
    $crumbs->push($slogan->id, route('dashboard.films.slogans.show', ['film' => $film, 'slogan' => $slogan]));
});

Breadcrumbs::for('dashboard.films.slogans.edit', function (Crumbs $crumbs, Film $film, FilmSlogan $slogan) {
    $crumbs->parent('dashboard.films.slogans.show', $film, $slogan);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.slogans.edit', ['film' => $film, 'slogan' => $slogan]));
});

// Film Synopses

Breadcrumbs::for('dashboard.films.synopses.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.synopses'));
});

Breadcrumbs::for('dashboard.films.synopses.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.synopses.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.synopses.create', $film));
});

Breadcrumbs::for('dashboard.films.synopses.show', function (Crumbs $crumbs, Film $film, FilmSynopsis $synopsis) {
    $crumbs->parent('dashboard.films.synopses.index', $film);
    $crumbs->push($synopsis->id, route('dashboard.films.synopses.show', ['film' => $film, 'synopsis' => $synopsis]));
});

Breadcrumbs::for('dashboard.films.synopses.edit', function (Crumbs $crumbs, Film $film, FilmSynopsis $synopsis) {
    $crumbs->parent('dashboard.films.synopses.show', $film, $synopsis);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.synopses.edit', ['film' => $film, 'synopsis' => $synopsis]));
});

// Film Trivia

Breadcrumbs::for('dashboard.films.trivias.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.trivias'));
});

Breadcrumbs::for('dashboard.films.trivias.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.trivias.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.trivias.create', $film));
});

Breadcrumbs::for('dashboard.films.trivias.show', function (Crumbs $crumbs, Film $film, FilmTrivia $trivia) {
    $crumbs->parent('dashboard.films.trivias.index', $film);
    $crumbs->push($trivia->id, route('dashboard.films.trivias.show', ['film' => $film, 'trivia' => $trivia]));
});

Breadcrumbs::for('dashboard.films.trivias.edit', function (Crumbs $crumbs, Film $film, FilmTrivia $trivia) {
    $crumbs->parent('dashboard.films.trivias.show', $film, $trivia);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.trivias.edit', ['film' => $film, 'trivia' => $trivia]));
});

// Film Goofs

Breadcrumbs::for('dashboard.films.goofs.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.goofs'));
});

Breadcrumbs::for('dashboard.films.goofs.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.goofs.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.goofs.create', $film));
});

Breadcrumbs::for('dashboard.films.goofs.show', function (Crumbs $crumbs, Film $film, FilmGoof $goof) {
    $crumbs->parent('dashboard.films.goofs.index', $film);
    $crumbs->push($goof->id, route('dashboard.films.goofs.show', ['film' => $film, 'goof' => $goof]));
});

Breadcrumbs::for('dashboard.films.goofs.edit', function (Crumbs $crumbs, Film $film, FilmGoof $goof) {
    $crumbs->parent('dashboard.films.goofs.show', $film, $goof);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.goofs.edit', ['film' => $film, 'goof' => $goof]));
});

// Film credits

Breadcrumbs::for('dashboard.films.credits.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.credits'));
});

Breadcrumbs::for('dashboard.films.credits.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.credits.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.credits.create', $film));
});

Breadcrumbs::for('dashboard.films.credits.show', function (Crumbs $crumbs, Film $film, FilmCredit $credit) {
    $crumbs->parent('dashboard.films.credits.index', $film);
    $crumbs->push($credit->id, route('dashboard.films.credits.show', ['film' => $film, 'credit' => $credit]));
});

Breadcrumbs::for('dashboard.films.credits.edit', function (Crumbs $crumbs, Film $film, FilmCredit $credit) {
    $crumbs->parent('dashboard.films.credits.show', $film, $credit);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.credits.edit', ['film' => $film, 'credit' => $credit]));
});

// Film connections

Breadcrumbs::for('dashboard.films.connections.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.connections'));
});

Breadcrumbs::for('dashboard.films.connections.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.connections.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.connections.create', $film));
});

Breadcrumbs::for('dashboard.films.connections.show', function (Crumbs $crumbs, Film $film, FilmConnection $connection) {
    $crumbs->parent('dashboard.films.connections.index', $film);
    $crumbs->push($connection->connectedFilm->title, route('dashboard.films.connections.show', ['film' => $film, 'connection' => $connection]));
});

Breadcrumbs::for('dashboard.films.connections.edit', function (Crumbs $crumbs, Film $film, FilmConnection $connection) {
    $crumbs->parent('dashboard.films.connections.show', $film, $connection);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.connections.edit', ['film' => $film, 'connection' => $connection]));
});

// Film locations

Breadcrumbs::for('dashboard.films.locations.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.locations'));
});

Breadcrumbs::for('dashboard.films.locations.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.locations.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.locations.create', $film));
});

Breadcrumbs::for('dashboard.films.locations.show', function (Crumbs $crumbs, Film $film, FilmLocation $location) {
    $crumbs->parent('dashboard.films.locations.index', $film);
    $crumbs->push($location->location->getPlace(), route('dashboard.films.locations.show', ['film' => $film, 'location' => $location]));
});

Breadcrumbs::for('dashboard.films.locations.edit', function (Crumbs $crumbs, Film $film, FilmLocation $location) {
    $crumbs->parent('dashboard.films.locations.show', $film, $location);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.locations.edit', ['film' => $film, 'location' => $location]));
});

// Film companies

Breadcrumbs::for('dashboard.films.companies.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.companies'));
});

Breadcrumbs::for('dashboard.films.companies.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.companies.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.companies.create', $film));
});

Breadcrumbs::for('dashboard.films.companies.show', function (Crumbs $crumbs, Film $film, FilmCompany $company) {
    $crumbs->parent('dashboard.films.companies.index', $film);
    $crumbs->push($company->company->name, route('dashboard.films.companies.show', ['film' => $film, 'company' => $company]));
});

Breadcrumbs::for('dashboard.films.companies.edit', function (Crumbs $crumbs, Film $film, FilmCompany $company) {
    $crumbs->parent('dashboard.films.companies.show', $film, $company);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.companies.edit', ['film' => $film, 'company' => $company]));
});

// Film companies release dates

Breadcrumbs::for('dashboard.films.companies.release-dates.index', function (Crumbs $crumbs, Film $film, FilmCompany $company) {
    $crumbs->parent('dashboard.films.companies.show', $film, $company);
    $crumbs->push(trans('menu.release_dates'));
});

Breadcrumbs::for('dashboard.films.companies.release-dates.create', function (Crumbs $crumbs, Film $film, FilmCompany $company) {
    $crumbs->parent('dashboard.films.companies.release-dates.index', $film, $company);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.companies.release-dates.create', $film));
});

Breadcrumbs::for('dashboard.films.companies.release-dates.show', function (Crumbs $crumbs, Film $film, FilmCompany $company, FilmReleaseDate $releaseDate) {
    $crumbs->parent('dashboard.films.companies.release-dates.index', $film, $company);
    $crumbs->push($releaseDate->id, route('dashboard.films.companies.release-dates.show', ['film' => $film, 'company' => $company, 'release_date' => $releaseDate]));
});

Breadcrumbs::for('dashboard.films.companies.release-dates.edit', function (Crumbs $crumbs, Film $film, FilmCompany $company, FilmReleaseDate $releaseDate) {
    $crumbs->parent('dashboard.films.companies.release-dates.show', $film, $company, $releaseDate);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.companies.release-dates.edit', ['film' => $film, 'company' => $company, 'release_date' => $releaseDate]));
});

// Film release dates

Breadcrumbs::for('dashboard.films.release-dates.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.release_dates'));
});

Breadcrumbs::for('dashboard.films.release-dates.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.release-dates.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.release-dates.create', $film));
});

Breadcrumbs::for('dashboard.films.release-dates.show', function (Crumbs $crumbs, Film $film, FilmReleaseDate $releaseDate) {
    $crumbs->parent('dashboard.films.release-dates.index', $film);
    $crumbs->push($releaseDate->id, route('dashboard.films.release-dates.show', ['film' => $film, 'release_date' => $releaseDate]));
});

Breadcrumbs::for('dashboard.films.release-dates.edit', function (Crumbs $crumbs, Film $film, FilmReleaseDate $releaseDate) {
    $crumbs->parent('dashboard.films.release-dates.show', $film, $releaseDate);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.release-dates.edit', ['film' => $film, 'release_date' => $releaseDate]));
});

// Film Alternate Versions

Breadcrumbs::for('dashboard.films.alternate-versions.index', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.show', $film);
    $crumbs->push(trans('menu.alternate_versions'));
});

Breadcrumbs::for('dashboard.films.alternate-versions.create', function (Crumbs $crumbs, Film $film) {
    $crumbs->parent('dashboard.films.alternate-versions.index', $film);
    $crumbs->push(trans('adminlte.create'), route('dashboard.films.alternate-versions.create', $film));
});

Breadcrumbs::for('dashboard.films.alternate-versions.show', function (Crumbs $crumbs, Film $film, FilmAlternateVersion $alternateVersion) {
    $crumbs->parent('dashboard.films.alternate-versions.index', $film);
    $crumbs->push($alternateVersion->id, route('dashboard.films.alternate-versions.show', ['film' => $film, 'alternate_version' => $alternateVersion]));
});

Breadcrumbs::for('dashboard.films.alternate-versions.edit', function (Crumbs $crumbs, Film $film, FilmAlternateVersion $alternateVersion) {
    $crumbs->parent('dashboard.films.alternate-versions.show', $film, $alternateVersion);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.films.alternate-versions.edit', ['film' => $film, 'alternate_version' => $alternateVersion]));
});
