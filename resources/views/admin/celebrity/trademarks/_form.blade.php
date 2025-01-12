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
                            {!! Html::label('Qiziqarli fakt', 'trademark_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trademark_uz', old('trademark_uz', $trademark->trademark_uz ?? null))
                                ->class('form-control' . ($errors->has('trademark_uz') ? ' is-invalid' : ''))
                                ->id('trademark_uz')->rows(10)->required(); !!}
                            @if ($errors->has('trademark_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trademark_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Қизиқарли факт', 'trademark_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trademark_uz_cy', old('trademark_uz_cy', $trademark->trademark_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('trademark_uz_cy') ? ' is-invalid' : ''))
                                ->id('trademark_uz_cy')->rows(10); !!}
                            @if ($errors->has('trademark_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trademark_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Интересный факт', 'trademark_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trademark_ru', old('trademark_ru', $trademark->trademark_ru ?? null))
                                ->class('form-control' . ($errors->has('trademark_ru') ? ' is-invalid' : ''))
                                ->id('trademark_ru')->rows(10)->required(); !!}
                            @if ($errors->has('trademark_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trademark_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Interesting fact', 'trademark_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trademark_en', old('trademark_en', $trademark->trademark_en ?? null))
                                ->class('form-control' . ($errors->has('trademark_en') ? ' is-invalid' : ''))
                                ->id('trademark_en')->rows(10)->required(); !!}
                            @if ($errors->has('trademark_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trademark_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($trademark ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('trademark_uz');
        CKEDITOR.replace('trademark_uz_cy');
        CKEDITOR.replace('trademark_ru');
        CKEDITOR.replace('trademark_en');
    </script>

@endsection
