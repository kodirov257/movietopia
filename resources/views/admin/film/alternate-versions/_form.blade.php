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
                <div class="form-group">
                    {!! Html::label('Versiyasi', 'version_uz')->class('col-form-label'); !!}
                    {!! Html::text('version_uz', old('version_uz', $alternateVersion->version_uz ?? null))
                        ->class('form-control' . ($errors->has('version_uz') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('version_uz'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('version_uz') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Версияси', 'version_uz_cy')->class('col-form-label'); !!}
                    {!! Html::text('version_uz_cy', old('version_uz_cy', $alternateVersion->version_uz_cy ?? null))
                        ->class('form-control' . ($errors->has('version_uz_cy') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('version_uz_cy'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('version_uz_cy') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Версия', 'version_ru')->class('col-form-label'); !!}
                    {!! Html::text('version_ru', old('version_ru', $alternateVersion->version_ru ?? null))
                        ->class('form-control' . ($errors->has('version_ru') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('version_ru'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('version_ru') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Version', 'version_en')->class('col-form-label'); !!}
                    {!! Html::text('version_en', old('version_en', $alternateVersion->version_en ?? null))
                        ->class('form-control' . ($errors->has('version_en') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('version_en'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('version_en') }}</strong></span>
                    @endif
                </div>
                @if(!$film->mainAlternateVersion()->exists())
                    <div class="form-group">
                        {!! Html::label(__('adminlte.main'), 'main')->class('col-form-label'); !!}
                        {!! Html::checkbox('main', old('main', $alternateVersion->main ?? null))
                            ->class('form-control' . ($errors->has('main') ? ' is-invalid' : '')); !!}
                        @if ($errors->has('main'))
                            <span
                                class="invalid-feedback"><strong>{{ $errors->first('main') }}</strong></span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($alternateVersion ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)

@endsection
