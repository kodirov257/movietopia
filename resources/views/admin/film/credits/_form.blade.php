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
                            {!! Html::label('Ishonish qiyin bo`lgan faqt', 'credit_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('credit_uz', old('credit_uz', $credit->credit_uz ?? null))
                                ->class('form-control' . ($errors->has('credit_uz') ? ' is-invalid' : ''))
                                ->id('credit_uz')->rows(10)->required(); !!}
                            @if ($errors->has('credit_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('credit_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Ишониш қийин бўлган фақт', 'credit_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('credit_uz_cy', old('credit_uz_cy', $credit->credit_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('credit_uz_cy') ? ' is-invalid' : ''))
                                ->id('credit_uz_cy')->rows(10); !!}
                            @if ($errors->has('credit_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('credit_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Безумный факт', 'credit_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('credit_ru', old('credit_ru', $credit->credit_ru ?? null))
                                ->class('form-control' . ($errors->has('credit_ru') ? ' is-invalid' : ''))
                                ->id('credit_ru')->rows(10)->required(); !!}
                            @if ($errors->has('credit_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('credit_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Crazy credit', 'credit_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('credit_en', old('credit_en', $credit->credit_en ?? null))
                                ->class('form-control' . ($errors->has('credit_en') ? ' is-invalid' : ''))
                                ->id('credit_en')->rows(10)->required(); !!}
                            @if ($errors->has('credit_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('credit_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($credit ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('credit_uz');
        CKEDITOR.replace('credit_uz_cy');
        CKEDITOR.replace('credit_ru');
        CKEDITOR.replace('credit_en');
    </script>

@endsection
