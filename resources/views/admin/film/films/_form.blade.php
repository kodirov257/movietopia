@include('layouts.admin.flash')

@include('admin.film.films._css')


<div class="row">
    <div class="col-md-12">
        <div class="card card-blue card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label('Nomi', 'title_uz')->class('col-form-label'); !!}
                            {!! Html::text('title_uz', old('title_uz', $film->title_uz ?? null))
                                ->class('form-control' . ($errors->has('title_uz') ? ' is-invalid' : ''))->required(); !!}
                            @if ($errors->has('title_uz'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('title_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label('Номи', 'title_uz_cy')->class('col-form-label'); !!}
                            {!! Html::text('title_uz_cy', old('title_uz_cy', $film->title_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('title_uz_cy') ? ' is-invalid' : '')); !!}
                            @if ($errors->has('title_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('title_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label('Название', 'title_ru')->class('col-form-label'); !!}
                            {!! Html::text('title_ru', old('title_ru', $film->title_ru ?? null))
                                ->class('form-control' . ($errors->has('title_ru') ? ' is-invalid' : ''))->required(); !!}
                            @if ($errors->has('title_ru'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('title_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label('Title', 'title_en')->class('col-form-label'); !!}
                            {!! Html::text('title_en', old('title_en', $film->title_en ?? null))
                                ->class('form-control' . ($errors->has('title_en') ? ' is-invalid' : ''))->required(); !!}
                            @if ($errors->has('title_en'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('title_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label('Slug', 'slug')->class('col-form-label') !!}
                            {!! Html::text('slug', old('slug', $film->slug ?? null))->class('form-control' . ($errors->has('slug') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('slug'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(__('menu.genres'), 'genres')->class('col-form-label') !!}
                            {!! Html::select('genres[]', $genres, old('genres', $film ? $film->genresList() : null))->multiple()
                                    ->id('genres')->class('form-control' . ($errors->has('genres') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('genres'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('genres') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(__('menu.types'), 'types')->class('col-form-label') !!}
                            {!! Html::select('types[]', $types, old('types', $film ? $film->typesList() : null))->multiple()
                                    ->id('types')->class('form-control' . ($errors->has('types') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('types'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('types') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-cyan card-outline">
            <div class="card-header"><h3 class="card-title">{{ trans('movie.film.poster') }}</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label for="poster" class="col-form-label">{{ trans('adminlte.image') }}</label>
                    <div class="file-loading">
                        <input id="poster-input" class="file" type="file" name="poster" accept=".jpg,.jpeg,.png,.gif">
                    </div>
                    @if ($errors->has('poster'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('poster') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-green card-outline">
            <div class="card-header"><h3 class="card-title">{{ trans('adminlte.main') }}</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.original_title'), 'original_title')->class('col-form-label') !!}
                            {!! Html::text('original_title', old('original_title', $film->original_title ?? null))
                                    ->class('form-control' . ($errors->has('original_title') ? ' is-invalid' : ''))->required() !!}
                            @if($errors->has('original_title'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('original_title') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label(trans('movie.film.world_released_at'), 'world_released_at')->class('col-form-label'); !!}
                            {!! Html::date('world_released_at', old('world_released_at', $film ? ($film->world_released_at ?? null) : null))
                                    ->class('form-control' . ($errors->has('world_released_at') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('world_released_at'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('world_released_at') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.age_rating'), 'age_rating')->class('col-form-label') !!}
                            {!! Html::number('age_rating', old('age_rating', $film->age_rating ?? 0), 0)
                                    ->class('form-control' . ($errors->has('age_rating') ? ' is-invalid' : ''))->required() !!}
                            @if($errors->has('age_rating'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('age_rating') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.tv_series'), 'tv_series')->class('col-form-label') !!}
                            {!! Html::checkbox('tv_series', old('tv_series', $film->tv_series ?? null))
                                    ->id('tv_series')->class('form-control' . ($errors->has('tv_series') ? ' is-invalid' : '')) !!}
                            @if($errors->has('tv_series'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('tv_series') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label(trans('movie.film.last_season_released_at'), 'last_season_released_at')->class('col-form-label'); !!}
                            {!! Html::date('last_season_released_at', old('last_season_released_at', $film ? ($film->last_season_released_at ?? null) : null))
                                    ->id('last_season_released_at')->class('form-control' . ($errors->has('last_season_released_at') ? ' is-invalid' : ''))->disabled() !!}
                            @if ($errors->has('last_season_released_at'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('last_season_released_at') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label(trans('movie.film.last_episode_released_at'), 'last_episode_released_at')->class('col-form-label'); !!}
                            {!! Html::date('last_episode_released_at', old('last_episode_released_at', $film ? ($film->last_episode_released_at ?? null) : null))
                                    ->id('last_episode_released_at')->class('form-control' . ($errors->has('last_episode_released_at') ? ' is-invalid' : ''))->disabled() !!}
                            @if ($errors->has('last_episode_released_at'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('last_episode_released_at') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.duration'), 'duration_minutes')->class('col-form-label') !!}
                            {!! Html::number('duration_minutes', old('duration_minutes', $film->duration_minutes ?? null), 0)
                                    ->class('form-control' . ($errors->has('duration_minutes') ? ' is-invalid' : ''))->required() !!}
                            @if($errors->has('duration_minutes'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('duration_minutes') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.estimated'), 'budget_estimated')->class('col-form-label') !!}
                            {!! Html::checkbox('budget_estimated', old('budget_estimated', $film->budget_estimated ?? null, 1))
                                    ->class('form-control' . ($errors->has('budget_estimated') ? ' is-invalid' : '')) !!}
                            @if($errors->has('budget_estimated'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('budget_estimated') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.budget') . ' min', 'budget_from')->class('col-form-label') !!}
                            {!! Html::number('budget_from', old('budget_from', $film->budget_from ?? null), 0)
                                    ->class('form-control' . ($errors->has('budget_from') ? ' is-invalid' : '')) !!}
                            @if($errors->has('budget_from'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('budget_from') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.budget') . ' max', 'budget_to')->class('col-form-label') !!}
                            {!! Html::number('budget_to', old('budget_to', $film->budget_to ?? null), 0)
                                    ->class('form-control' . ($errors->has('budget_to') ? ' is-invalid' : '')) !!}
                            @if($errors->has('budget_to'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('budget_to') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.filming_date_from'), 'filming_date_from')->class('col-form-label'); !!}
                            {!! Html::date('filming_date_from', old('filming_date_from', $film ? ($film->filming_date_from ?? null) : null))
                                    ->class('form-control' . ($errors->has('filming_date_from') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('filming_date_from'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('filming_date_from') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.filming_date_to'), 'filming_date_to')->class('col-form-label'); !!}
                            {!! Html::date('filming_date_to', old('filming_date_to', $film ? ($film->filming_date_to ?? null) : null))
                                    ->class('form-control' . ($errors->has('filming_date_to') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('filming_date_to'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('filming_date_to') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.box_office_local'), 'box_office_local')->class('col-form-label') !!}
                            {!! Html::number('box_office_local', old('box_office_local', $film->box_office_local ?? null), 0)
                                    ->class('form-control' . ($errors->has('box_office_local') ? ' is-invalid' : '')) !!}
                            @if($errors->has('box_office_local'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('box_office_local') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.box_office_worldwide'), 'box_office_worldwide')->class('col-form-label') !!}
                            {!! Html::number('box_office_worldwide', old('box_office_worldwide', $film->box_office_worldwide ?? null), 0)
                                    ->class('form-control' . ($errors->has('box_office_worldwide') ? ' is-invalid' : '')) !!}
                            @if($errors->has('box_office_worldwide'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('box_office_worldwide') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.imdb_rating'), 'imdb_rating')->class('col-form-label') !!}
                            {!! Html::number('imdb_rating', old('imdb_rating', $film->imdb_rating ?? null), 0, null, 0.01)
                                    ->class('form-control' . ($errors->has('imdb_rating') ? ' is-invalid' : '')) !!}
                            @if($errors->has('imdb_rating'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('imdb_rating') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(trans('movie.film.imdb_rating_voting'), 'imdb_rating_voting')->class('col-form-label'); !!}
                            {!! Html::number('imdb_rating_voting', old('imdb_rating_voting', $film ? ($film->imdb_rating_voting ?? null) : null))
                                    ->class('form-control' . ($errors->has('imdb_rating_voting') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('imdb_rating_voting'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('imdb_rating_voting') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-yellow card-outline">
            <div class="card-header"><h3 class="card-title">{{ __('movie.film.sites') }}</h3></div>
            <div class="card-body">
                <p><button id="add-site" class="btn btn-primary" value="">{{ __('adminlte.add') }} <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></p>
                <div class="row" id="site-row">
                    @if(old('sites'))
                        @foreach(old('sites') as $siteIndex => $site)
                            <div class="col-md-11 site-input-{{ $siteIndex + 1 }}">
                                <div class="form-group">
                                    {!! Html::text('sites[]', $site)->class('form-control' . ($errors->has('sites') ? ' is-invalid' : '')) !!}
                                </div>
                            </div>

                            <div class="form-group site-remove-button-{{ $siteIndex + 1 }}">
                                <button class="remove-site btn btn-danger" onclick="removeSite(event, {{ $siteIndex + 1 }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                        @endforeach
                        @php
                            $siteIndex++;
                        @endphp
                    @elseif($film && $film->sites)
                        @foreach($film->sites as $siteIndex => $site)
                            <div class="col-md-11 site-input-{{ $siteIndex + 1 }}">
                                <div class="form-group">
                                    {!! Html::text('sites[]', $site)->class('form-control' . ($errors->has('sites') ? ' is-invalid' : '')) !!}
                                </div>
                            </div>

                            <div class="form-group site-remove-button-{{ $siteIndex + 1 }}">
                                <button class="remove-site btn btn-danger" onclick="removeSite(event, {{ $siteIndex + 1 }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                        @endforeach
                        @php
                            $siteIndex++;
                        @endphp
                    @else
                        @php
                            $siteIndex = 1;
                        @endphp
                        <div class="col-md-11 site-input-{{ $siteIndex }}">
                            <div class="form-group">
                                {!! Html::text('sites[]')->class('form-control' . ($errors->has('sites') ? ' is-invalid' : '')) !!}
                            </div>
                        </div>

                        <div class="form-group site-remove-button-{{ $siteIndex }}">
                            <button class="remove-site btn btn-danger" onclick="removeSite(event, {{ $siteIndex }})"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        </div>
                    @endif
                    @if($errors->has('sites'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('sites') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-gray-dark card-outline">
            <div class="card-header"><h3 class="card-title">SEO</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.title'), 'meta_title')->class('col-form-label'); !!}
                            {!! Html::text('meta_title', old('meta_title', $film ? $film->meta_json->title : null))
                                    ->class('form-control' . ($errors->has('meta_title') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('meta_title'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('meta_title') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.keywords'), 'meta_keywords')->class('col-form-label'); !!}
                            {!! Html::text('meta_keywords', old('meta_keywords', $film ? $film->meta_json->keywords : null))
                                     ->class('form-control' . ($errors->has('meta_title') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('meta_keywords'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('meta_keywords') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.description'), 'meta_description')->class('col-form-label'); !!}
                            {!! Html::textarea('meta_description', old('meta_description', $film ? $film->meta_json->description : null))
                                ->class('form-control' . $errors->has('meta_description') ? ' is-invalid' : '')
                                ->id('meta_description')->rows(10)->required() !!}
                            @if ($errors->has('meta_description'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('meta_description') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($film ? 'edit' : 'save')) }}</button>
</div>

@include('admin.film.films._js')
