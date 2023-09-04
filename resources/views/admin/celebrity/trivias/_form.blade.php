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
                            {!! Html::label('Qiziqarli fakt', 'trivia_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trivia_uz', old('trivia_uz', $trivia->trivia_uz ?? null))
                                ->class('form-control' . ($errors->has('trivia_uz') ? ' is-invalid' : ''))
                                ->id('trivia_uz')->rows(10)->required(); !!}
                            @if ($errors->has('trivia_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trivia_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Қизиқарли факт', 'trivia_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trivia_uz_cy', old('trivia_uz_cy', $trivia->trivia_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('trivia_uz_cy') ? ' is-invalid' : ''))
                                ->id('trivia_uz_cy')->rows(10); !!}
                            @if ($errors->has('trivia_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trivia_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Интересный факт', 'trivia_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trivia_ru', old('trivia_ru', $trivia->trivia_ru ?? null))
                                ->class('form-control' . ($errors->has('trivia_ru') ? ' is-invalid' : ''))
                                ->id('trivia_ru')->rows(10)->required(); !!}
                            @if ($errors->has('trivia_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trivia_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Interesting fact', 'trivia_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('trivia_en', old('trivia_en', $trivia->trivia_en ?? null))
                                ->class('form-control' . ($errors->has('trivia_en') ? ' is-invalid' : ''))
                                ->id('trivia_en')->rows(10)->required(); !!}
                            @if ($errors->has('trivia_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('trivia_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($trivia ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('trivia_uz');
        CKEDITOR.replace('trivia_uz_cy');
        CKEDITOR.replace('trivia_ru');
        CKEDITOR.replace('trivia_en');
    </script>

@endsection
