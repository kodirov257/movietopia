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
                    {!! Html::label('Shiori', 'slogan_uz')->class('col-form-label'); !!}
                    {!! Html::text('slogan_uz', old('slogan_uz', $slogan->slogan_uz ?? null))
                        ->class('form-control' . ($errors->has('slogan_uz') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('slogan_uz'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('slogan_uz') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Шиори', 'slogan_uz_cy')->class('col-form-label'); !!}
                    {!! Html::text('slogan_uz_cy', old('slogan_uz_cy', $slogan->slogan_uz_cy ?? null))
                        ->class('form-control' . ($errors->has('slogan_uz_cy') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('slogan_uz_cy'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('slogan_uz_cy') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Слоган', 'slogan_ru')->class('col-form-label'); !!}
                    {!! Html::text('slogan_ru', old('slogan_ru', $slogan->slogan_ru ?? null))
                        ->class('form-control' . ($errors->has('slogan_ru') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('slogan_ru'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('slogan_ru') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Slogan', 'slogan_en')->class('col-form-label'); !!}
                    {!! Html::text('slogan_en', old('slogan_en', $slogan->slogan_en ?? null))
                        ->class('form-control' . ($errors->has('slogan_en') ? ' is-invalid' : ''))->required(); !!}
                    @if ($errors->has('slogan_en'))
                        <span
                            class="invalid-feedback"><strong>{{ $errors->first('slogan_en') }}</strong></span>
                    @endif
                </div>
                @if(!$film->mainSlogan()->exists())
                    <div class="form-group">
                        {!! Html::label(__('adminlte.main'), 'main')->class('col-form-label'); !!}
                        {!! Html::checkbox('main', old('main', $slogan->main ?? null))
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
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($slogan ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)

@endsection
