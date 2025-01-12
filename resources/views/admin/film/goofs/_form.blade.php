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
                <div class="tab-content">
                    <div class="tab-pane active" id="uzbek" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Film xatosi', 'goof_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('goof_uz', old('goof_uz', $goof->goof_uz ?? null))
                                ->class('form-control' . ($errors->has('goof_uz') ? ' is-invalid' : ''))
                                ->id('goof_uz')->rows(10)->required(); !!}
                            @if ($errors->has('goof_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('goof_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Филм хатоси', 'goof_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('goof_uz_cy', old('goof_uz_cy', $goof->goof_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('goof_uz_cy') ? ' is-invalid' : ''))
                                ->id('goof_uz_cy')->rows(10); !!}
                            @if ($errors->has('goof_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('goof_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Ошибка фильма', 'goof_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('goof_ru', old('goof_ru', $goof->goof_ru ?? null))
                                ->class('form-control' . ($errors->has('goof_ru') ? ' is-invalid' : ''))
                                ->id('goof_ru')->rows(10)->required(); !!}
                            @if ($errors->has('goof_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('goof_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Film goof', 'goof_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('goof_en', old('goof_en', $goof->goof_en ?? null))
                                ->class('form-control' . ($errors->has('goof_en') ? ' is-invalid' : ''))
                                ->id('goof_en')->rows(10)->required(); !!}
                            @if ($errors->has('goof_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('goof_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.type'), 'type_id')->class('col-form-label') !!}
                            {!! Html::select('type_id', $types, old('type_id', $goof->type_id ?? null))
                                    ->id('type_id')->class('form-control' . ($errors->has('type_id') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('type_id'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('type_id') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('movie.film.is_spoiler'), 'spoiler')->class('col-form-label'); !!}
                            {!! Html::checkbox('spoiler', old('spoiler', $goof->spoiler ?? null))
                                ->class('form-control' . ($errors->has('spoiler') ? ' is-invalid' : '')); !!}
                            @if ($errors->has('spoiler'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('spoiler') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($goof ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('goof_uz');
        CKEDITOR.replace('goof_uz_cy');
        CKEDITOR.replace('goof_ru');
        CKEDITOR.replace('goof_en');
    </script>

@endsection
