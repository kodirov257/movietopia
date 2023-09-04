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
        <div class="card card-blue card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(__('menu.celebrities'), 'relative_id')->class('col-form-label') !!}
                            {!! Html::select('relative_id', $relative && $relative->relative_id ? $defaultRelative : [],
                                    old('relative_id', $relative->relative_id ?? null)
                                    )->id('relative_id')->class('form-control' . ($errors->has('relative_id') ? ' is-invalid' : '')) !!}
                            @if($errors->has('relative_id'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('relative_id') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="uzbek" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Ismi', 'first_name_uz')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_uz', old('first_name_uz', $relative->first_name_uz ?? null))
                                        ->id('first_name_uz')->class('form-control' . ($errors->has('first_name_uz') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('first_name_uz'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('first_name_uz') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Sharifi', 'last_name_uz')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_uz', old('last_name_uz', $relative->last_name_uz ?? null))
                                        ->id('last_name_uz')->class('form-control' . ($errors->has('last_name_uz') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('last_name_uz'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('last_name_uz') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Otasining ismi', 'middle_name_uz')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_uz', old('middle_name_uz', $relative->middle_name_uz ?? null))
                                        ->id('middle_name_uz')->class('form-control' . ($errors->has('middle_name_uz') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_uz'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('middle_name_uz') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Исми', 'first_name_uz_cy')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_uz_cy', old('first_name_uz_cy', $relative->first_name_uz_cy ?? null))
                                        ->id('first_name_uz_cy')->class('form-control' . ($errors->has('first_name_uz_cy') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('first_name_uz_cy'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('first_name_uz_cy') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Шарифи', 'last_name_uz_cy')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_uz_cy', old('last_name_uz_cy', $relative->last_name_uz_cy ?? null))
                                        ->id('last_name_uz_cy')->class('form-control' . ($errors->has('last_name_uz_cy') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('last_name_uz_cy'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('last_name_uz_cy') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Отасининг исми', 'middle_name_uz_cy')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_uz_cy', old('middle_name_uz_cy', $relative->middle_name_uz_cy ?? null))
                                        ->id('middle_name_uz_cy')->class('form-control' . ($errors->has('middle_name_uz_cy') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_uz_cy'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('middle_name_uz_cy') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Имя', 'first_name_ru')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_ru', old('first_name_ru', $relative->first_name_ru ?? null))
                                        ->id('first_name_ru')->class('form-control' . ($errors->has('first_name_ru') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('first_name_ru'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('first_name_ru') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Фамилия', 'last_name_ru')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_ru', old('last_name_ru', $relative->last_name_ru ?? null))
                                        ->id('last_name_ru')->class('form-control' . ($errors->has('last_name_ru') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('last_name_ru'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('last_name_ru') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Отчество', 'middle_name_ru')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_ru', old('middle_name_ru', $relative->middle_name_ru ?? null))
                                        ->id('middle_name_ru')->class('form-control' . ($errors->has('middle_name_ru') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_ru'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('middle_name_ru') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('First Name', 'first_name_en')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_en', old('first_name_en', $relative->first_name_en ?? null))
                                        ->id('first_name_en')->class('form-control' . ($errors->has('first_name_en') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('first_name_en'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('first_name_en') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Last Name', 'last_name_en')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_en', old('last_name_en', $relative->last_name_en ?? null))
                                        ->id('last_name_en')->class('form-control' . ($errors->has('last_name_en') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('last_name_en'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('last_name_en') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Отчество', 'middle_name_en')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_en', old('middle_name_en', $relative->middle_name_en ?? null))
                                        ->id('middle_name_en')->class('form-control' . ($errors->has('middle_name_en') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_en'))
                                        <span
                                            class="invalid-feedback"><strong>{{ $errors->first('middle_name_en') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-gray card-outline">
            <div class="card-header"><h3 class="card-title">{{ __('adminlte.celebrity.relation_type') }}</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.relation_type'), 'relation_type')->class('col-form-label'); !!}
                            {!! Html::select('relation_type', \App\Models\Celebrity\CelebrityRelative::relativeTypesList(),
                                old('relation_type', $relative->relation_type ?? null))
                                ->class('form-control' . ($errors->has('relation_type') ? ' is-invalid' : ''))
                                ->id('relation_type')->placeholder(__('adminlte.celebrity.relation_type')) !!}
                            @if($errors->has('relation_type'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('relation_type') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.marry_date'), 'marry_date')->class('col-form-label'); !!}
                            {!! Html::date('marry_date', old('marry_date', $relative ? ($relative->marry_date ?? null) : null))
                                    ->id('marry_date')->class('form-control' . ($errors->has('marry_date') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('marry_date'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('marry_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.children'), 'children')->class('col-form-label'); !!}
                            {!! Html::number('children', old('children', $relative ? ($relative->children ?? null) : null))
                                    ->id('children')->class('form-control' . ($errors->has('children') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('children'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('children') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.divorce_date'), 'divorce_date')->class('col-form-label'); !!}
                            {!! Html::date('divorce_date', old('divorce_date', $relative ? ($relative->divorce_date ?? null) : null))
                                    ->id('divorce_date')->class('form-control' . ($errors->has('divorce_date') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('divorce_date'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('divorce_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.divorce_reason'), 'divorce_reason')->class('col-form-label'); !!}
                            {!! Html::select('divorce_reason', \App\Models\Celebrity\CelebrityRelative::divorceReasonList(),
                                    old('divorce_reason', $relative->divorce_reason ?? null))
                                    ->id('divorce_reason')->class('form-control' . ($errors->has('divorce_reason') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('divorce_date'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('divorce_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($relative ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script>
        $('#relation_type').select2().on('change', function (e) {
            if (!this.value) {
                disableMarriage();
            } else if (JSON.parse('{{ json_encode(array_keys(\App\Models\Celebrity\CelebrityRelative::spousesTypesList())) }}'.replace(/&quot;/g,'"')).includes(this.value)) {
                enableMarriage();
            } else {
                disableMarriage();
            }
        });

        $('#relative_id').select2({
            ajax: {
                url: '/api/search-celebrities',
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
                        results: data.data.celebrities,
                        pagination: {
                            more: (params.page * 10) < data.data.total,
                        },
                    };
                },
                delay: 250,
            },
            placeholder: '{{ __('menu.celebrities') }}',
            minimumInputLength: 2,
            templateResult: function (celebrity) {
                if (celebrity.loading) {
                    return celebrity.text;
                }

                let $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    (celebrity.photo_url ? ("   <div class='select2-result-repository__avatar'><img src='" + celebrity.photo_url + "' /></div>") : '') +
                    "   <div class='select2-result-repository__meta'>" +
                    "       <div class='select2-result-repository__title'></div>" +
                    "   </div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(celebrity.full_name);

                return $container;
            },
            templateSelection: function (celebrity) {
                return celebrity.full_name || celebrity.text;
            },
            allowClear: true,
        }).on('change', function (e) {
            if (this.value) {
                disableNames();
            } else {
                enableNames();
            }
        });

        function disableNames() {
            $('#first_name_uz').prop('disabled', true);
            $('#first_name_uz_cy').prop('disabled', true);
            $('#first_name_ru').prop('disabled', true);
            $('#first_name_en').prop('disabled', true);
            $('#last_name_uz').prop('disabled', true);
            $('#last_name_uz_cy').prop('disabled', true);
            $('#last_name_ru').prop('disabled', true);
            $('#last_name_en').prop('disabled', true);
            $('#middle_name_uz').prop('disabled', true);
            $('#middle_name_uz_cy').prop('disabled', true);
            $('#middle_name_ru').prop('disabled', true);
            $('#middle_name_en').prop('disabled', true);
        }

        function enableNames() {
            $('#first_name_uz').removeAttr('disabled');
            $('#first_name_uz_cy').removeAttr('disabled');
            $('#first_name_ru').removeAttr('disabled');
            $('#first_name_en').removeAttr('disabled');
            $('#last_name_uz').removeAttr('disabled');
            $('#last_name_uz_cy').removeAttr('disabled');
            $('#last_name_ru').removeAttr('disabled');
            $('#last_name_en').removeAttr('disabled');
            $('#middle_name_uz').removeAttr('disabled');
            $('#middle_name_uz_cy').removeAttr('disabled');
            $('#middle_name_ru').removeAttr('disabled');
            $('#middle_name_en').removeAttr('disabled');
        }

        function disableMarriage() {
            $('#marry_date').prop('disabled', true);
            $('#children').prop('disabled', true);
            $('#divorce_date').prop('disabled', true);
            $('#divorce_reason').prop('disabled', true);
        }

        function enableMarriage() {
            $('#marry_date').removeAttr('disabled');
            $('#children').removeAttr('disabled');
            $('#divorce_date').removeAttr('disabled');
            $('#divorce_reason').removeAttr('disabled');
        }

        $(document).ready(function (e) {
            disableMarriage();
        });
    </script>
@endsection
