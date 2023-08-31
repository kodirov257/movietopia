@include('layouts.admin.flash')

<div class="row">
    <div class="col-md-12">
        <div class="card card-gray card-outline">
            <div class="card-header"><h3 class="card-title"></h3></div>
            <div class="card-body">
                <div class="form-group">
                    {!! Html::label('Nomi', 'name_uz')->class('col-form-label') !!}
                    {!! Html::text('name_uz', old('name_uz', $position->name_uz ?? null))->class('form-control' . ($errors->has('name_uz') ? ' is-invalid' : ''))->required() !!}
                    @if($errors->has('name_uz'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('name_uz') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Номи', 'name_uz_cy')->class('col-form-label') !!}
                    {!! Html::text('name_uz_cy', old('name_uz_cy', $position->name_uz_cy ?? null))->class('form-control' . ($errors->has('name_uz_cy') ? ' is-invalid' : '')) !!}
                    @if($errors->has('name_uz_cy'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('name_uz_cy') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Название', 'name_ru')->class('col-form-label') !!}
                    {!! Html::text('name_ru', old('name_ru', $position->name_ru ?? null))->class('form-control' . ($errors->has('name_ru') ? ' is-invalid' : ''))->required() !!}
                    @if($errors->has('name_ru'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('name_ru') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Name', 'name_en')->class('col-form-label') !!}
                    {!! Html::text('name_en', old('name_en', $position->name_en ?? null))->class('form-control' . ($errors->has('name_en') ? ' is-invalid' : ''))->required() !!}
                    @if($errors->has('name_en'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('name_en') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Html::label('Slug', 'slug')->class('col-form-label') !!}
                    {!! Html::text('slug', old('slug', $position->slug ?? null))->class('form-control' . ($errors->has('slug') ? ' is-invalid' : '')) !!}
                    @if ($errors->has('slug'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-gray card-outline">
            <div class="card-header"><h3 class="card-title">SEO</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.title'), 'meta_title')->class('col-form-label'); !!}
                            {!! Html::text('meta_title', old('meta_title', $position ? $position->meta_json->title : null))
                                    ->class('form-control' . ($errors->has('meta_title') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('meta_title'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('meta_title') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.keywords'), 'meta_keywords')->class('col-form-label'); !!}
                            {!! Html::text('meta_keywords', old('meta_keywords', $position ? $position->meta_json->keywords : null))
                                     ->class('form-control' . ($errors->has('meta_title') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('meta_keywords'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('meta_keywords') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.description'), 'meta_description')->class('col-form-label'); !!}
                            {!! Html::textarea('meta_description', old('meta_description', $position ? $position->meta_json->description : null))
                                ->class('form-control' . $errors->has('meta_description') ? ' is-invalid' : '')
                                ->id('meta_description')->rows(10) !!}
                            @if ($errors->has('meta_description'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('meta_description') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($position ? 'edit' : 'save')) }}</button>
</div>
