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
                            {!! Html::label('Sujeti', 'storyline_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('storyline_uz', old('storyline_uz', $film->storyline_uz ?? null))
                                ->class('form-control' . ($errors->has('storyline_uz') ? ' is-invalid' : ''))
                                ->id('storyline_uz')->rows(10)->required(); !!}
                            @if ($errors->has('storyline_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('storyline_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Сужети', 'storyline_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('storyline_uz_cy', old('storyline_uz_cy', $film->storyline_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('storyline_uz_cy') ? ' is-invalid' : ''))
                                ->id('storyline_uz_cy')->rows(10); !!}
                            @if ($errors->has('storyline_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('storyline_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Сюжетная линия', 'storyline_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('storyline_ru', old('storyline_ru', $film->storyline_ru ?? null))
                                ->class('form-control' . ($errors->has('storyline_ru') ? ' is-invalid' : ''))
                                ->id('storyline_ru')->rows(10)->required(); !!}
                            @if ($errors->has('storyline_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('storyline_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Storyline', 'storyline_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('storyline_en', old('storyline_en', $film->storyline_en ?? null))
                                ->class('form-control' . ($errors->has('storyline_en') ? ' is-invalid' : ''))
                                ->id('storyline_en')->rows(10)->required(); !!}
                            @if ($errors->has('storyline_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('storyline_en') }}</strong></span>
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
        CKEDITOR.replace('storyline_uz');
        CKEDITOR.replace('storyline_uz_cy');
        CKEDITOR.replace('storyline_ru');
        CKEDITOR.replace('storyline_en');
    </script>

@endsection
