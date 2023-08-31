<?php

use App\Models\Company;
use App\Models\Country;
use App\Models\Genre;
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


// Countries

Breadcrumbs::for('dashboard.countries.index', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.home');
    $crumbs->push(trans('menu.countries'), route('dashboard.countries.index'));
});

Breadcrumbs::for('dashboard.countries.create', function (Crumbs $crumbs) {
    $crumbs->parent('dashboard.countries.index');
    $crumbs->push(trans('adminlte.create'), route('dashboard.countries.create'));
});

Breadcrumbs::for('dashboard.countries.show', function (Crumbs $crumbs, Country $country) {
    $crumbs->parent('dashboard.countries.index');
    $crumbs->push($country->name, route('dashboard.countries.show', $country));
});

Breadcrumbs::for('dashboard.countries.edit', function (Crumbs $crumbs, Country $country) {
    $crumbs->parent('dashboard.countries.show', $country);
    $crumbs->push(trans('adminlte.edit'), route('dashboard.countries.edit', $country));
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
