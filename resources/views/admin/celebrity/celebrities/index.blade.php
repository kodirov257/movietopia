@if (!config('adminlte.enabled_laravel_mix'))
    @php($javaScriptSectionName = 'js')
@else
    @php($javaScriptSectionName = 'mix_adminlte_js')
@endif

<?php /* @var $celebrities \App\Models\Celebrity\Celebrity[] */ ?>

<x-admin-page-layout>
    @section('content')
        <p><a href="{{ route('dashboard.celebrities.create') }}"
              class="btn btn-success">{{ trans('adminlte.celebrity.add') }}</a></p>

        <div class="card mb-4">
            <div class="card-body">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::text('full_name', request('full_name'))->class('form-control')->placeholder(trans('adminlte.full_name')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::select('country_id', $defaultLivePlace ?? [], request('country_id'))->id('country_id')
                                        ->class('form-control')->placeholder(trans('adminlte.country_region.region')) !!}
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
                <td>{{ __('adminlte.celebrity.photo') }}</td>
                <td>ShIO</td>
                <td>ФИО</td>
                <td>Full Name</td>
                <td>{{ __('adminlte.celebrity.live_places') }}</td>
                <td>{{ __('adminlte.celebrity.social_networks') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach($celebrities as $celebrity)
                <tr>
                    <td>
                        @if ($celebrity->photo)
                            <a href="{{ $celebrity->photoOriginal }}" target="_blank"><img src="{{ $celebrity->photoThumbnail }}"></a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dashboard.celebrities.show', $celebrity) }}">
                            {{ $celebrity->last_name_uz }} {{ $celebrity->first_name_uz }} @if($celebrity->middle_name_uz) {{ $celebrity->middle_name_uz }} @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('dashboard.celebrities.show', $celebrity) }}">
                            {{ $celebrity->last_name_ru }} {{ $celebrity->first_name_ru }} @if($celebrity->middle_name_ru) {{ $celebrity->middle_name_ru }} @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('dashboard.celebrities.show', $celebrity) }}">
                            {{ $celebrity->last_name_en }} {{ $celebrity->first_name_en }} @if($celebrity->middle_name_en) {{ $celebrity->middle_name_en }} @endif
                        </a>
                    </td>
                    <td>
                        @if($celebrity->livePlace)
                            {{ __('adminlte.celebrity.live_date_place', ['place' => $celebrity->livePlace->getPlace()]) }}
                            <br>
                        @endif
                        @if($celebrity->birthPlace)
                            {{ __('adminlte.celebrity.birth_date_place', ['date' => $celebrity->birth_date, 'place' => $celebrity->birthPlace->getPlace()]) }}
                            <br>
                        @endif
                        @if($celebrity->deathPlace)
                            {{ __('adminlte.celebrity.death_date_place', ['date' => $celebrity->death_date, 'place' => $celebrity->deathPlace->getPlace()]) }}
                            <br>
                        @endif
                    </td>
                    <td>
                        @if($celebrity->twitter)
                            <a href="{{ $celebrity->twitter }}">{{ $celebrity->twitter }}</a><br>
                        @endif
                        @if($celebrity->facebook)
                            <a href="{{ $celebrity->facebook }}">{{ $celebrity->facebook }}</a><br>
                        @endif
                        @if($celebrity->instagram)
                            <a href="{{ $celebrity->instagram }}">{{ $celebrity->instagram }}</a><br>
                        @endif
                        @if($celebrity->google_plus)
                            <a href="{{ $celebrity->google_plus }}">{{ $celebrity->google_plus }}</a><br>
                        @endif
                        @if($celebrity->youtube)
                            <a href="{{ $celebrity->youtube }}">{{ $celebrity->youtube }}</a><br>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $celebrities->links() }}
    @endsection

    @section($javaScriptSectionName)
        <script>
            $('#country_id').select2({
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
                placeholder: '{{ __('menu.countries_regions') }}',
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
        </script>
    @endsection
</x-admin-page-layout>
