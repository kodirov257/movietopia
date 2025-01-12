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
                            {!! Html::label('Bog`langan film', 'connection_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('connection_uz', old('connection_uz', $connection->connection_uz ?? null))
                                ->class('form-control' . ($errors->has('connection_uz') ? ' is-invalid' : ''))
                                ->id('connection_uz')->rows(10)->required(); !!}
                            @if ($errors->has('connection_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('connection_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Боғланган филм', 'connection_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('connection_uz_cy', old('connection_uz_cy', $connection->connection_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('connection_uz_cy') ? ' is-invalid' : ''))
                                ->id('connection_uz_cy')->rows(10); !!}
                            @if ($errors->has('connection_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('connection_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Связанный фильм', 'connection_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('connection_ru', old('connection_ru', $connection->connection_ru ?? null))
                                ->class('form-control' . ($errors->has('connection_ru') ? ' is-invalid' : ''))
                                ->id('connection_ru')->rows(10)->required(); !!}
                            @if ($errors->has('connection_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('connection_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Connection', 'connection_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('connection_en', old('connection_en', $connection->connection_en ?? null))
                                ->class('form-control' . ($errors->has('connection_en') ? ' is-invalid' : ''))
                                ->id('connection_en')->rows(10)->required(); !!}
                            @if ($errors->has('connection_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('connection_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.type'), 'type')->class('col-form-label') !!}
                            {!! Html::select('type', \App\Models\Film\FilmConnection::typesList(), old('type', $connection->type ?? null))
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
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($connection ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('connection_uz');
        CKEDITOR.replace('connection_uz_cy');
        CKEDITOR.replace('connection_ru');
        CKEDITOR.replace('connection_en');
    </script>

@endsection
