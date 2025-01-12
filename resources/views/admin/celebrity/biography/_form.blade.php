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
                            {!! Html::label('Biografiya', 'biography_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('biography_uz', old('biography_uz', $celebrity->biography_uz ?? null))
                                ->class('form-control' . ($errors->has('biography_uz') ? ' is-invalid' : ''))
                                ->id('biography_uz')->rows(10)->required(); !!}
                            @if ($errors->has('biography_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('biography_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Биография', 'biography_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('biography_uz_cy', old('biography_uz_cy', $celebrity->biography_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('biography_uz_cy') ? ' is-invalid' : ''))
                                ->id('biography_uz_cy')->rows(10); !!}
                            @if ($errors->has('biography_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('biography_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Биография', 'biography_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('biography_ru', old('biography_ru', $celebrity->biography_ru ?? null))
                                ->class('form-control' . ($errors->has('biography_ru') ? ' is-invalid' : ''))
                                ->id('biography_ru')->rows(10)->required(); !!}
                            @if ($errors->has('biography_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('biography_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Biography', 'biography_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('biography_en', old('biography_en', $celebrity->biography_en ?? null))
                                ->class('form-control' . ($errors->has('biography_en') ? ' is-invalid' : ''))
                                ->id('biography_en')->rows(10)->required(); !!}
                            @if ($errors->has('biography_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('biography_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($celebrity ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('biography_uz');
        CKEDITOR.replace('biography_uz_cy');
        CKEDITOR.replace('biography_ru');
        CKEDITOR.replace('biography_en');
    </script>

@endsection
