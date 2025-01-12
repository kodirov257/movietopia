@if (!config('adminlte.enabled_laravel_mix'))
    @php($javaScriptSectionName = 'js')
@else
    @php($javaScriptSectionName = 'mix_adminlte_js')
@endif

<?php /* @var $films \App\Models\Film\Film[] */ ?>

<x-admin-page-layout>
    @section('content')
        <p><a href="{{ route('dashboard.films.create') }}" class="btn btn-success">{{ trans('adminlte.film.add') }}</a></p>

        <div class="card mb-4">
            <div class="card-body">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::text('title', request('title'))->class('form-control')->placeholder(trans('adminlte.title')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('genre_id', $genres, request('genre_id'))->id('genre_id')
                                        ->class('form-control')->placeholder(trans('menu.genres')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('company_id', $companies, request('company_id'))->id('company_id')
                                        ->class('form-control')->placeholder(trans('menu.companies')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('country_id', $countries, request('country_id'))->id('country_id')
                                        ->class('form-control')->placeholder(trans('menu.countries')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('connection_id', [], request('connection_id'))->id('connection_id')
                                        ->class('form-control')->placeholder(trans('movie.film.connections')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('type_id', $types, request('type_id'))->id('type_id')
                                        ->class('form-control')->placeholder(trans('movie.film.type')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('language_id', $languages, request('language_id'))->id('language_id')
                                        ->class('form-control')->placeholder(trans('movie.film.languages')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('location_id', [], request('location_id'))->id('location_id')
                                        ->class('form-control')->placeholder(trans('movie.film.locations')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('status', \App\Models\Film\Film::statusesList(), request('status'))->id('status')
                                        ->class('form-control')->placeholder(trans('adminlte.status')) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Html::date('release_date_from', request('release_date_from'))->id('release_date_from')
                                                ->class('form-control')->placeholder(__('movie.film.world_released_at'))!!}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Html::date('release_date_to', request('release_date_to'))->id('release_date_to')
                                                ->class('form-control')->placeholder(__('movie.film.to')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Html::button(trans('adminlte.search'), 'submit')->class('btn btn-primary') !!}
                                {!! Html::a('?', trans('adminlte.clear'))->class('btn btn-outline-secondary') !!}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>{{ __('movie.film.poster') }}</td>
                <td>{{ __('adminlte.title') }}</td>
                <td>{{ __('movie.film.world_released_at') }}</td>
                <td>{{ __('movie.film.tv_series') }}</td>
                <td>{{ __('adminlte.status') }}</td>
                <td>{{ __('movie.film.age_rating') }}</td>
                <td>{{ __('movie.film.film_rating') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach($films as $film)
                <tr>
                    <td>
                        @if ($film->poster)
                            <a href="{{ $film->posterOriginal }}" target="_blank"><img src="{{ $film->posterThumbnail }}"></a>
                        @endif
                    </td>
                    <td><a href="{{ route('dashboard.films.show', $film) }}">{{ $film->title }}</a></td>
                    <td>{{ $film->world_released_at }}</td>
                    <td>
                        @if($film->tv_series)
                            {{ __('movie.film.tv_series') }}
                        @else
                            {{ __('movie.film.film') }}
                        @endif
                    </td>
                    <td>{{ $film->statusLabel() }}</td>
                    <td>{{ $film->age_rating }}+</td>
                    <td>{{ __('movie.film.rating_and_number_of_votes', ['rating' => $film->film_rating, 'vote_number' => $film->film_rating_number]) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $films->links() }}
    @endsection

    @section($javaScriptSectionName)
        <script>
            $('#location_id').select2({
                ajax: {
                    url: '/api/search-regions',
                    method: 'GET',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            name: params.term,
                            page: params.page || 1,
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.data.regions,
                            pagination: {
                                more: (params.page * 10) < data.data.total,
                            },
                        };
                    },
                    delay: 250,
                },
                placeholder: '{{ __('movie.film.locations') }}',
                minimumInputLength: 2,
                templateResult: function (region) {
                    if (region.loading) {
                        return region.text;
                    }

                    return region.name || region.text;
                },
                templateSelection: function (region) {
                    return region.name || region.text;
                },
                allowClear: true,
            });

            $('#connection_id').select2({
                ajax: {
                    url: '/api/search-films',
                    method: 'GET',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            title: params.term,
                            page: params.page || 1,
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.data.films,
                            pagination: {
                                more: (params.page * 10) < data.data.total,
                            },
                        };
                    },
                    delay: 250,
                },
                placeholder: '{{ __('movie.film.connections') }}',
                minimumInputLength: 2,
                templateResult: function (film) {
                    if (film.loading) {
                        return film.text;
                    }

                    return film.title || film.text;
                },
                templateSelection: function (film) {
                    return film.title || film.text;
                },
                allowClear: true,
            });
        </script>
    @endsection
</x-admin-page-layout>
