@if (!config('adminlte.enabled_laravel_mix'))
    @php($cssSectionName = 'css')
    @php($javaScriptSectionName = 'js')
@else
    @php($cssSectionName = 'mix_adminlte_css')
    @php($javaScriptSectionName = 'mix_adminlte_js')
@endif

@include('layouts.admin.flash')

<div class="row">
    <div class="col-md-12">
        <div class="card card-gray card-outline">
            <div class="card-header"><h3 class="card-title"></h3></div>
            <div class="card-body">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Html::label(__('adminlte.film.location'), 'location_id')->class('col-form-label') !!}
                        {!! Html::select('location_id', $location && $location->location_id ? $defaultLocation : [],
                                old('location_id', $location->location_id ?? null))
                                ->id('location_id')->class('form-control' . ($errors->has('location_id') ? ' is-invalid' : '')) !!}
                        {{--                            {!! Html::hidden('location_id', $location->location_id ?? null) !!}--}}
                        @if($errors->has('location_id'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('location_id') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="uzbek" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Tafsilotlari', 'details_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_uz', old('details_uz', $location->details_uz ?? null))
                                ->class('form-control' . ($errors->has('details_uz') ? ' is-invalid' : ''))
                                ->id('details_uz')->rows(10)->required(); !!}
                            @if ($errors->has('details_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Тафсилотлари', 'details_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_uz_cy', old('details_uz_cy', $location->details_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('details_uz_cy') ? ' is-invalid' : ''))
                                ->id('details_uz_cy')->rows(10); !!}
                            @if ($errors->has('details_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Подробности', 'details_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_ru', old('details_ru', $location->details_ru ?? null))
                                ->class('form-control' . ($errors->has('details_ru') ? ' is-invalid' : ''))
                                ->id('details_ru')->rows(10)->required(); !!}
                            @if ($errors->has('details_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Details', 'details_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_en', old('details_en', $location->details_en ?? null))
                                ->class('form-control' . ($errors->has('details_en') ? ' is-invalid' : ''))
                                ->id('details_en')->rows(10)->required(); !!}
                            @if ($errors->has('details_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($location ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('details_uz');
        CKEDITOR.replace('details_uz_cy');
        CKEDITOR.replace('details_ru');
        CKEDITOR.replace('details_en');

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
            placeholder: '{{ __('adminlte.film.location') }}',
            minimumInputLength: 2,
            allowClear: true,
            templateResult: function (region) {
                if (region.loading) {
                    return region.text;
                }

                return region.name || region.text;
            },
            templateSelection: function (region) {
                return region.name || region.text;
            },
        });
    </script>

@endsection
