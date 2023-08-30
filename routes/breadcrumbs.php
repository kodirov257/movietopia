<?php

use App\Models\Genre;
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
