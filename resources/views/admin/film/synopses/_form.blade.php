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
                            {!! Html::label('Qisqa sharhi', 'synopsis_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('synopsis_uz', old('synopsis_uz', $synopsis->synopsis_uz ?? null))
                                ->class('form-control' . ($errors->has('synopsis_uz') ? ' is-invalid' : ''))
                                ->id('synopsis_uz')->rows(10)->required(); !!}
                            @if ($errors->has('synopsis_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('synopsis_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Қисқа шарҳи', 'synopsis_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('synopsis_uz_cy', old('synopsis_uz_cy', $synopsis->synopsis_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('synopsis_uz_cy') ? ' is-invalid' : ''))
                                ->id('synopsis_uz_cy')->rows(10); !!}
                            @if ($errors->has('synopsis_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('synopsis_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Краткий обзор', 'synopsis_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('synopsis_ru', old('synopsis_ru', $synopsis->synopsis_ru ?? null))
                                ->class('form-control' . ($errors->has('synopsis_ru') ? ' is-invalid' : ''))
                                ->id('synopsis_ru')->rows(10)->required(); !!}
                            @if ($errors->has('synopsis_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('synopsis_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Synopsis', 'synopsis_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('synopsis_en', old('synopsis_en', $synopsis->synopsis_en ?? null))
                                ->class('form-control' . ($errors->has('synopsis_en') ? ' is-invalid' : ''))
                                ->id('synopsis_en')->rows(10)->required(); !!}
                            @if ($errors->has('synopsis_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('synopsis_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.type'), 'type')->class('col-form-label') !!}
                            {!! Html::select('type', \App\Models\Film\FilmSynopsis::typesList(), old('type', $synopsis->type ?? null))
                                    ->id('type')->class('form-control' . ($errors->has('type') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('type'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('type') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($synopsis ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('synopsis_uz');
        CKEDITOR.replace('synopsis_uz_cy');
        CKEDITOR.replace('synopsis_ru');
        CKEDITOR.replace('synopsis_en');
    </script>

@endsection
