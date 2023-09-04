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
                            {!! Html::label('Qiziqarli fakt', 'quote_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('quote_uz', old('quote_uz', $quote->quote_uz ?? null))
                                ->class('form-control' . ($errors->has('quote_uz') ? ' is-invalid' : ''))
                                ->id('quote_uz')->rows(10)->required(); !!}
                            @if ($errors->has('quote_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('quote_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Қизиқарли факт', 'quote_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('quote_uz_cy', old('quote_uz_cy', $quote->quote_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('quote_uz_cy') ? ' is-invalid' : ''))
                                ->id('quote_uz_cy')->rows(10); !!}
                            @if ($errors->has('quote_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('quote_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Интересный факт', 'quote_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('quote_ru', old('quote_ru', $quote->quote_ru ?? null))
                                ->class('form-control' . ($errors->has('quote_ru') ? ' is-invalid' : ''))
                                ->id('quote_ru')->rows(10)->required(); !!}
                            @if ($errors->has('quote_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('quote_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Interesting fact', 'quote_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('quote_en', old('quote_en', $quote->quote_en ?? null))
                                ->class('form-control' . ($errors->has('quote_en') ? ' is-invalid' : ''))
                                ->id('quote_en')->rows(10)->required(); !!}
                            @if ($errors->has('quote_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('quote_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($quote ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('quote_uz');
        CKEDITOR.replace('quote_uz_cy');
        CKEDITOR.replace('quote_ru');
        CKEDITOR.replace('quote_en');
    </script>

@endsection
