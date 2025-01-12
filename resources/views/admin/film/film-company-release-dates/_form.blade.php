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
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Html::label(__('adminlte.country_region.name'), 'country_id')->class('col-form-label') !!}
                        {!! Html::select('country_id', $countries, old('country_id', $releaseDate->country_id ?? null))
                                ->id('country_id')->class('form-control' . ($errors->has('country_id') ? ' is-invalid' : '')) !!}
                        @if($errors->has('country_id'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('country_id') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="uzbek" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Tafsilotlari', 'details_uz')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_uz', old('details_uz', $releaseDate->details_uz ?? null))
                                ->class('form-control' . ($errors->has('details_uz') ? ' is-invalid' : ''))
                                ->id('details_uz')->rows(10)->required(); !!}
                            @if ($errors->has('details_uz'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Тафсилотлари', 'details_uz_cy')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_uz_cy', old('details_uz_cy', $releaseDate->details_uz_cy ?? null))
                                ->class('form-control' . ($errors->has('details_uz_cy') ? ' is-invalid' : ''))
                                ->id('details_uz_cy')->rows(10); !!}
                            @if ($errors->has('details_uz_cy'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Подробности', 'details_ru')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_ru', old('details_ru', $releaseDate->details_ru ?? null))
                                ->class('form-control' . ($errors->has('details_ru') ? ' is-invalid' : ''))
                                ->id('details_ru')->rows(10)->required(); !!}
                            @if ($errors->has('details_ru'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="form-group">
                            {!! Html::label('Details', 'details_en')->class('col-form-label'); !!}
                            <br>
                            {!! Html::textarea('details_en', old('details_en', $releaseDate->details_en ?? null))
                                ->class('form-control' . ($errors->has('details_en') ? ' is-invalid' : ''))
                                ->id('details_en')->rows(10)->required(); !!}
                            @if ($errors->has('details_en'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('details_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Html::label(__('adminlte.release-date'), 'release_date')->class('col-form-label') !!}
                        {!! Html::date('release_date', old('release_date', $releaseDate ? ($releaseDate->release_date ?? null) : null))
                                ->id('release_date')->class('form-control' . ($errors->has('release_date') ? ' is-invalid' : '')) !!}
                        @if($errors->has('release_date'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('release_date') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($releaseDate ? 'edit' : 'save')) }}</button>
</div>

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('details_uz');
        CKEDITOR.replace('details_uz_cy');
        CKEDITOR.replace('details_ru');
        CKEDITOR.replace('details_en');
    </script>

@endsection
