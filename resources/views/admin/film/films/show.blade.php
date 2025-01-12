<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.films.edit', $film) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <a href="{{ route('dashboard.films.description.edit', $film) }}" class="btn btn-primary mr-1">{{ trans('adminlte.film.edit_description') }}</a>
            <a href="{{ route('dashboard.films.storyline.edit', $film) }}" class="btn btn-primary mr-1">{{ trans('adminlte.film.edit_storyline') }}</a>
            <p><a href="{{ route('dashboard.films.slogans.create', $film) }}" class="btn btn-dark">{{ __('adminlte.film.add_slogan') }}</a></p>
            <p><a href="{{ route('dashboard.films.synopses.create', $film) }}" class="btn btn-default">{{ __('adminlte.film.add_synopsis') }}</a></p>
            <p><a href="{{ route('dashboard.films.trivias.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_trivia') }}</a></p>
            <p><a href="{{ route('dashboard.films.goofs.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_goof') }}</a></p>
            <p><a href="{{ route('dashboard.films.connections.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_connection') }}</a></p>
            <p><a href="{{ route('dashboard.films.locations.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_location') }}</a></p>
            <p><a href="{{ route('dashboard.films.companies.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_company') }}</a></p>
            <p><a href="{{ route('dashboard.films.release-dates.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_release_date') }}</a></p>
            <p><a href="{{ route('dashboard.films.alternate-versions.create', $film) }}" class="btn btn-secondary">{{ __('adminlte.film.add_alternate_version') }}</a></p>
            <form method="POST" action="{{ route('dashboard.films.destroy', $film) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('{{ trans('adminlte.delete_confirmation_message') }}')">{{ trans('adminlte.delete') }}</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-blue card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><th>ID</th><td>{{ $film->id }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Nomi</td></tr>
                                    <tr><td>{{ $film->title_uz }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Номи</td></tr>
                                    <tr><td>{{ $film->title_uz_cy }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Название</td></tr>
                                    <tr><td>{{ $film->title_ru }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Title</td></tr>
                                    <tr><td>{{ $film->title_en }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><th>Slug</th><td>{{ $film->slug }}</td></tr>
                                    </tbody>
                                </table>
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
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    @if ($film->poster)
                                        <a href="{{ $film->posterOriginal }}" target="_blank"><img src="{{ $film->posterThumbnail }}"></a>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-green card-outline">
                    <div class="card-header"><h3 class="card-title">{{ trans('adminlte.main') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr><th>{{ __('movie.film.original_title') }}</th><td>{{ $film->original_title }}</td></tr>
                            <tr><th>{{ __('movie.film.world_released_at') }}</th><td>{{ $film->world_released_at }}</td></tr>
                            <tr><th>{{ __('movie.film.age_rating') }}</th><td>{{ $film->age_rating }}</td></tr>
                            <tr><th>{{ __('movie.film.tv_series') }}</th><td>{{ __('movie.' . ($film->tv_series ? 'yes' : 'no')) }}</td></tr>
                            @if($film->tv_series)
                                <tr><th>{{ __('movie.film.last_season_released_at') }}</th><td>{{ $film->last_season_released_at }}</td></tr>
                                <tr><th>{{ __('movie.film.last_episode_released_at') }}</th><td>{{ $film->last_episode_released_at }}</td></tr>
                            @endif
                            <tr><th>{{ __('movie.film.duration') }}</th><td>{{ $film->duration }}</td></tr>
                            <tr>
                                <th>{{ __('menu.genres') }}</th>
                                <td>
                                    @if($film->genres()->exists())
                                        @foreach($film->genres as $key => $genre)
                                            <a href="{{ route('genres.show', $genre) }}">{{ $genre->name . ($key === array_key_last($film->genres) ? ', ' : '')}}</a>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr><th>{{ __('movie.film.filming_date_from') }}</th><td>{{ $film->filming_date_from }}</td></tr>
                            <tr><th>{{ __('movie.film.filming_date_to') }}</th><td>{{ $film->filming_date_to }}</td></tr>
                            <tr><th>{{ __('movie.film.imdb_rating') }}</th><td>{{ $film->imdb_rating }}</td></tr>
                            <tr><th>{{ __('movie.film.imdb_rating_voting') }}</th><td>{{ $film->imdb_rating_voting }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-red card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('movie.finance') }}</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>{{ __('movie.film.estimated') }}</td></tr>
                                    <tr><td>{{ $film->budget_estimated }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>{{ __('movie.film.budget') }} min</td></tr>
                                    <tr><td>{{ $film->budget_from }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>{{ __('movie.film.budget') }} max</td></tr>
                                    <tr><td>{{ $film->budget_to }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>{{ __('movie.film.box_office_local') }}</td></tr>
                                    <tr><td>{{ $film->box_office_local }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>{{ __('movie.film.box_office_worldwide') }} min</td></tr>
                                    <tr><td>{{ $film->box_office_worldwide }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-lightblue card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('movie.film.description') }}</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Tavsifi</td></tr>
                                    <tr><td>{!! $film->description_uz !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Тавсифи</td></tr>
                                    <tr><td>{!! $film->description_uz_cy !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Описание</td></tr>
                                    <tr><td>{!! $film->description_ru !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Description</td></tr>
                                    <tr><td>{!! $film->description_en !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-lightblue card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('movie.film.storyline') }}</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Sujeti</td></tr>
                                    <tr><td>{!! $film->storyline_uz !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Сужети</td></tr>
                                    <tr><td>{!! $film->storyline_uz_cy !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Сюжетная линия</td></tr>
                                    <tr><td>{!! $film->storyline_ru !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Storyline</td></tr>
                                    <tr><td>{!! $film->storyline_en !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($film->sites))
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-lightblue card-outline">
                        <div class="card-header"><h3 class="card-title">{{ __('movie.film.sites') }}</h3></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                        @foreach($film->sites as $site)
                                            <tr><td><a href="{{ $site }}">{{ $site }}</a></td></tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($film->meta_json))
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray-dark card-outline">
                        <div class="card-header"><h3 class="card-title">SEO</h3></div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                <tr><th>{{ trans('adminlte.title') }}</th><td>{{ $film->meta_json->title }}</td></tr>
                                <tr><th>{{ trans('adminlte.keywords') }}</th><td>{{ $film->meta_json->keywords }}</td></tr>
                                <tr><th>{{ trans('adminlte.description') }}</th><td>{{ $film->meta_json->description }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">{{ trans('adminlte.other') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>{{ trans('adminlte.created_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $film->createdBy) }}">{{ $film->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $film->updatedBy) }}">{{ $film->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $film->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $film->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="slogans">
            <div class="card-header card-gray with-border">{{ __('menu.slogans') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.slogans.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_slogan') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Shiori</th>
                        <th>Слоган</th>
                        <th>Slogan</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($film->slogans as $slogan)
                        <tr>
                            <td>{{ $slogan->slogan_uz }}</td>
                            <td>{{ $slogan->slogan_ru }}</td>
                            <td>{{ $slogan->slogan_en }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.slogans.first', ['film' => $film, 'slogan' => $slogan]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.slogans.up', ['film' => $film, 'slogan' => $slogan]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.slogans.down', ['film' => $film, 'slogan' => $slogan]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.slogans.last', ['film' => $film, 'slogan' => $slogan]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.slogans.show', ['film' => $film, 'slogan' => $slogan]) }}">Show</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="synopses">
            <div class="card-header card-gray with-border">{{ __('menu.synopses') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.synopses.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_synopsis') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Qisqa sharhi</th>
                        <th>Краткий обзор</th>
                        <th>Synopsis</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->synopses as $synopsis)
                        <tr>
                            <td>{{ custom_substr($synopsis->synopsis_uz) }}</td>
                            <td>{{ custom_substr($synopsis->synopsis_ru) }}</td>
                            <td>{{ custom_substr($synopsis->synopsis_en) }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.synopses.first', ['film' => $film, 'synopsis' => $synopsis]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.synopses.up', ['film' => $film, 'synopsis' => $synopsis]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.synopses.down', ['film' => $film, 'synopsis' => $synopsis]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.synopses.last', ['film' => $film, 'synopsis' => $synopsis]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.synopses.show', ['film' => $film, 'synopsis' => $synopsis]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="trivias">
            <div class="card-header card-gray with-border">{{ __('menu.trivias') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.trivias.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_trivia') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Mish-mishlar</th>
                        <th>Слухи</th>
                        <th>Trivia</th>
                        <th>{{ __('adminlte.type') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->trivias as $trivia)
                        <tr>
                            <td>{{ custom_substr($trivia->trivia_uz) }}</td>
                            <td>{{ custom_substr($trivia->trivia_ru) }}</td>
                            <td>{{ custom_substr($trivia->trivia_en) }}</td>
                            <td>{{ $trivia->typeName() }}...</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.trivias.first', ['film' => $film, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.trivias.up', ['film' => $film, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.trivias.down', ['film' => $film, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.trivias.last', ['film' => $film, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.trivias.show', ['film' => $film, 'trivia' => $trivia]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="goofs">
            <div class="card-header card-gray with-border">{{ __('menu.goofs') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.goofs.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_goof') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Mish-mishlar</th>
                        <th>Слухи</th>
                        <th>Trivia</th>
                        <th>{{ __('adminlte.type') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->goofs as $goof)
                        <tr>
                            <td>{{ custom_substr($goof->goof_uz) }}</td>
                            <td>{{ custom_substr($goof->goof_ru) }}</td>
                            <td>{{ custom_substr($goof->goof_en) }}</td>
                            <td>{{ $goof->type->name }}...</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.goofs.first', ['film' => $film, 'goof' => $goof]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.goofs.up', ['film' => $film, 'goof' => $goof]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.goofs.down', ['film' => $film, 'goof' => $goof]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.goofs.last', ['film' => $film, 'goof' => $goof]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.goofs.show', ['film' => $film, 'goof' => $goof]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="connections">
            <div class="card-header card-gray with-border">{{ __('menu.connections') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.connections.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_connection') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminlte.film.connected_film') }}</th>
                        <th>Tafsilotlari</th>
                        <th>Подробности</th>
                        <th>Details</th>
                        <th>{{ __('adminlte.type') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->filmConnections as $filmConnection)
                        <tr>
                            <td><a href="{{ route('dashboard.films.show', $filmConnection->connectedFilm) }}">{{ $filmConnection->connectedFilm->title }}</a></td>
                            <td>{{ custom_substr($filmConnection->connection_uz) }}</td>
                            <td>{{ custom_substr($filmConnection->connection_ru) }}</td>
                            <td>{{ custom_substr($filmConnection->connection_en) }}</td>
                            <td>{{ $filmConnection->typeName() }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.connections.first', ['film' => $film, 'connection' => $filmConnection]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.connections.up', ['film' => $film, 'connection' => $filmConnection]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.connections.down', ['film' => $film, 'connection' => $filmConnection]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.connections.last', ['film' => $film, 'connection' => $filmConnection]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.connections.show', ['film' => $film, 'connection' => $filmConnection]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="locations">
            <div class="card-header card-gray with-border">{{ __('menu.locations') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.locations.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_location') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminlte.film.location') }}</th>
                        <th>Tafsilotlari</th>
                        <th>Подробности</th>
                        <th>Details</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->filmLocations as $location)
                        <tr>
                            <td><a href="{{ route('dashboard.country-regions.show', $location->location) }}">{{ $location->location->getPlace() }}</a></td>
                            <td>{{ custom_substr($location->details_uz) }}</td>
                            <td>{{ custom_substr($location->details_ru) }}</td>
                            <td>{{ custom_substr($location->details_en) }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.locations.first', ['film' => $film, 'location' => $location]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.locations.up', ['film' => $film, 'location' => $location]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.locations.down', ['film' => $film, 'location' => $location]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.locations.last', ['film' => $film, 'location' => $location]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.locations.show', ['film' => $film, 'location' => $location]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="companies">
            <div class="card-header card-gray with-border">{{ __('menu.companies') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.companies.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_company') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminlte.film.company') }}</th>
                        <th>Tafsilotlari</th>
                        <th>Подробности</th>
                        <th>Details</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->filmCompanies as $company)
                        <tr>
                            <td><a href="{{ route('dashboard.companies.show', $company->company) }}">{{ $company->company->name }}</a></td>
                            <td>{{ custom_substr($company->details_uz) }}</td>
                            <td>{{ custom_substr($company->details_ru) }}</td>
                            <td>{{ custom_substr($company->details_en) }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.companies.first', ['film' => $film, 'company' => $company]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.companies.up', ['film' => $film, 'company' => $company]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.companies.down', ['film' => $film, 'company' => $company]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.companies.last', ['film' => $film, 'company' => $company]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.companies.show', ['film' => $film, 'company' => $company]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="release-dates">
            <div class="card-header card-gray with-border">{{ __('menu.release_dates') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.release-dates.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_release_date') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminlte.release-date') }}</th>
                        <th>Tafsilotlari</th>
                        <th>Подробности</th>
                        <th>Details</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($film->releaseDates as $releaseDate)
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.films.release-dates.show', ['film' => $film, 'release_date' => $releaseDate]) }}">
                                    {{ $releaseDate->release_date }}
                                </a>
                            </td>
                            <td>{{ custom_substr($releaseDate->details_uz) }}</td>
                            <td>{{ custom_substr($releaseDate->details_ru) }}</td>
                            <td>{{ custom_substr($releaseDate->details_en) }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.release-dates.first', ['film' => $film, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.release-dates.up', ['film' => $film, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.release-dates.down', ['film' => $film, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.release-dates.last', ['film' => $film, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.release-dates.show', ['film' => $film, 'release_date' => $releaseDate]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="alternate-versions">
            <div class="card-header card-gray with-border">{{ __('menu.alternate_versions') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.alternate-versions.create', $film) }}" class="btn btn-success">{{ __('adminlte.film.add_alternate_version') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Versiyasi</th>
                        <th>Версия</th>
                        <th>Version</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($film->alternateVersions as $alternateVersion)
                        <tr>
                            <td>{{ $alternateVersion->version_uz }}</td>
                            <td>{{ $alternateVersion->version_ru }}</td>
                            <td>{{ $alternateVersion->version_en }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.alternate-versions.first', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.alternate-versions.up', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.alternate-versions.down', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.alternate-versions.last', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.alternate-versions.show', ['film' => $film, 'alternate_version' => $alternateVersion]) }}">Show</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endsection
</x-admin-page-layout>
