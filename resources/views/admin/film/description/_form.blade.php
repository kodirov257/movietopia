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
                            {!! Html::label('Tavsifi', 'description_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('description_uz', old('description_uz', $film->description_uz ?? null))
                                ->class('form-control' . ($errors->has('description_uz') ? ' is-invalid' : ''))
                                ->id('description_uz')->rows(10)->required(); !!}
                            @if ($errors->has('description_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('description_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Тавсифи', 'description_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('description_uz_cy', old('description_uz_cy', $film->description_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('description_uz_cy') ? ' is-invalid' : ''))
                                ->id('description_uz_cy')->rows(10); !!}
                            @if ($errors->has('description_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('description_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Описание', 'description_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('description_ru', old('description_ru', $film->description_ru ?? null))
                                ->class('form-control' . ($errors->has('description_ru') ? ' is-invalid' : ''))
                                ->id('description_ru')->rows(10)->required(); !!}
                            @if ($errors->has('description_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('description_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Description', 'description_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('description_en', old('description_en', $film->description_en ?? null))
                                ->class('form-control' . ($errors->has('description_en') ? ' is-invalid' : ''))
                                ->id('description_en')->rows(10)->required(); !!}
                            @if ($errors->has('description_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('description_en') }}</strong></span>
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

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('description_uz');
        CKEDITOR.replace('description_uz_cy');
        CKEDITOR.replace('description_ru');
        CKEDITOR.replace('description_en');
    </script>

@endsection
