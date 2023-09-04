@include('layouts.admin.flash')

@include('admin.celebrity.celebrities._css')


<div class="row">
    <div class="col-md-12">
        <div class="card card-blue card-outline">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="uzbek" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Ismi', 'first_name_uz')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_uz', old('first_name_uz', $celebrity->first_name_uz ?? null))
                                        ->class('form-control' . ($errors->has('first_name_uz') ? ' is-invalid' : ''))->required(); !!}
                                    @if ($errors->has('first_name_uz'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('first_name_uz') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Sharifi', 'last_name_uz')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_uz', old('last_name_uz', $celebrity->last_name_uz ?? null))
                                        ->class('form-control' . ($errors->has('last_name_uz') ? ' is-invalid' : ''))->required(); !!}
                                    @if ($errors->has('last_name_uz'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('last_name_uz') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Otasining ismi', 'middle_name_uz')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_uz', old('middle_name_uz', $celebrity->middle_name_uz ?? null))
                                        ->class('form-control' . ($errors->has('middle_name_uz') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_uz'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('middle_name_uz') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Html::label('Kasbi', 'professions_uz')->class('col-form-label'); !!}
                            {!! Html::text('professions_uz', old('professions_uz', $celebrity ? $celebrity->getProfessions('uz') : null))
                                ->class('form-control' . ($errors->has('professions_uz') ? ' is-invalid' : ''))->required(); !!}
                            @if ($errors->has('professions_uz'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('professions_uz') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane" id="uzbek-cyrill" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Исми', 'first_name_uz_cy')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_uz_cy', old('first_name_uz_cy', $celebrity->first_name_uz_cy ?? null))
                                        ->class('form-control' . ($errors->has('first_name_uz_cy') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('first_name_uz_cy'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('first_name_uz_cy') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Шарифи', 'last_name_uz_cy')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_uz_cy', old('last_name_uz_cy', $celebrity->last_name_uz_cy ?? null))
                                        ->class('form-control' . ($errors->has('last_name_uz_cy') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('last_name_uz_cy'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('last_name_uz_cy') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Отасининг исми', 'middle_name_uz_cy')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_uz_cy', old('middle_name_uz_cy', $celebrity->middle_name_uz_cy ?? null))
                                        ->class('form-control' . ($errors->has('middle_name_uz_cy') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_uz_cy'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('middle_name_uz_cy') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Html::label('Касби', 'professions_uz_cy')->class('col-form-label'); !!}
                            {!! Html::text('professions_uz_cy', old('professions_uz_cy', $celebrity ? $celebrity->getProfessions('uz_cy') : null))
                                ->class('form-control' . ($errors->has('professions_uz_cy') ? ' is-invalid' : '')); !!}
                            @if ($errors->has('professions_uz_cy'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('professions_uz_cy') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane" id="russian" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Имя', 'first_name_ru')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_ru', old('first_name_ru', $celebrity->first_name_ru ?? null))
                                        ->class('form-control' . ($errors->has('first_name_ru') ? ' is-invalid' : ''))->required(); !!}
                                    @if ($errors->has('first_name_ru'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('first_name_ru') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Фамилия', 'last_name_ru')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_ru', old('last_name_ru', $celebrity->last_name_ru ?? null))
                                        ->class('form-control' . ($errors->has('last_name_ru') ? ' is-invalid' : ''))->required(); !!}
                                    @if ($errors->has('last_name_ru'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('last_name_ru') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Отчество', 'middle_name_ru')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_ru', old('middle_name_ru', $celebrity->middle_name_ru ?? null))
                                        ->class('form-control' . ($errors->has('middle_name_ru') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_ru'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('middle_name_ru') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Html::label('Профессия', 'professions_ru')->class('col-form-label'); !!}
                            {!! Html::text('professions_ru', old('professions_ru', $celebrity ? $celebrity->getProfessions('ru') : null))
                                ->class('form-control' . ($errors->has('professions_ru') ? ' is-invalid' : ''))->required(); !!}
                            @if ($errors->has('professions_ru'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('professions_ru') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane" id="english" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('First Name', 'first_name_en')->class('col-form-label'); !!}
                                    {!! Html::text('first_name_en', old('first_name_en', $celebrity->first_name_en ?? null))
                                        ->class('form-control' . ($errors->has('first_name_en') ? ' is-invalid' : ''))->required(); !!}
                                    @if ($errors->has('first_name_en'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('first_name_en') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Last Name', 'last_name_en')->class('col-form-label'); !!}
                                    {!! Html::text('last_name_en', old('last_name_en', $celebrity->last_name_en ?? null))
                                        ->class('form-control' . ($errors->has('last_name_en') ? ' is-invalid' : ''))->required(); !!}
                                    @if ($errors->has('last_name_en'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('last_name_en') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Html::label('Отчество', 'middle_name_en')->class('col-form-label'); !!}
                                    {!! Html::text('middle_name_en', old('middle_name_en', $celebrity->middle_name_en ?? null))
                                        ->class('form-control' . ($errors->has('middle_name_en') ? ' is-invalid' : '')); !!}
                                    @if ($errors->has('middle_name_en'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('middle_name_en') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Html::label('Profession', 'professions_en')->class('col-form-label'); !!}
                            {!! Html::text('professions_en', old('professions_en', $celebrity ? $celebrity->getProfessions('en') : null))
                                ->class('form-control' . ($errors->has('professions_en') ? ' is-invalid' : ''))->required(); !!}
                            @if ($errors->has('professions_en'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('professions_en') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label('Slug', 'slug')->class('col-form-label') !!}
                            {!! Html::text('slug', old('slug', $celebrity->slug ?? null))->class('form-control' . ($errors->has('slug') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('slug'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-cyan card-outline">
            <div class="card-header"><h3 class="card-title">{{ trans('adminlte.celebrity.photo') }}</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label for="photo" class="col-form-label">{{ trans('adminlte.image') }}</label>
                    <div class="file-loading">
                        <input id="photo-input" class="file" type="file" name="photo" accept=".jpg,.jpeg,.png,.gif">
                    </div>
                    @if ($errors->has('photo'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('photo') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-green card-outline">
            <div class="card-header"><h3 class="card-title">{{ trans('adminlte.main') }}</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.birth_name'), 'birth_name')->class('col-form-label') !!}
                            {!! Html::text('birth_name', old('birth_name', $celebrity->birth_name ?? null))
                                    ->class('form-control' . ($errors->has('birth_name') ? ' is-invalid' : '')) !!}
                            @if($errors->has('birth_name'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('birth_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.original_name'), 'original_name')->class('col-form-label') !!}
                            {!! Html::text('original_name', old('original_name', $celebrity->original_name ?? null))
                                    ->class('form-control' . ($errors->has('original_name') ? ' is-invalid' : '')) !!}
                            @if($errors->has('original_name'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('original_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.nicknames'), 'nicknames')->class('col-form-label') !!}
                            {!! Html::text('nicknames', old('nicknames', !empty($celebrity->nicknames) ? $celebrity->getNicknames() : ''))
                                    ->class('form-control' . ($errors->has('nicknames') ? ' is-invalid' : '')) !!}
                            @if($errors->has('nicknames'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('nicknames') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.live_place'), 'live_place')->class('col-form-label') !!}
                            {!! Html::select('live_place', $celebrity && $celebrity->live_place ? $defaultLivePlace : [],
                                    old('live_place', $celebrity->live_place ?? null))
                                    ->id('live_place')->class('form-control' . ($errors->has('live_place') ? ' is-invalid' : '')) !!}
{{--                            {!! Html::hidden('live_place', $celebrity->live_place ?? null) !!}--}}
                            @if($errors->has('live_place'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('live_place') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.birth_place'), 'birth_place')->class('col-form-label') !!}
                            {!! Html::select('birth_place', $celebrity && $celebrity->birth_place ? $defaultLivePlace : [],
                                    old('birth_place', $celebrity->birth_place ?? null))
                                    ->id('birth_place')->class('form-control' . ($errors->has('birth_place') ? ' is-invalid' : '')) !!}
{{--                            {!! Html::hidden('birth_place', $celebrity->birth_place ?? null) !!}--}}
                            @if($errors->has('birth_place'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('birth_place') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.celebrity.birth_date'), 'birth_date')->class('col-form-label'); !!}
                            {!! Html::date('birth_date', old('birth_date', $celebrity ? ($celebrity->birth_date ?? null) : null))
                                    ->class('form-control' . ($errors->has('birth_date') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('birth_date'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('birth_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.celebrity.death_place'), 'death_place')->class('col-form-label') !!}
                            {!! Html::select('death_place', $celebrity && $celebrity->death_place ? $defaultLivePlace : [],
                                    old('death_place', $celebrity->death_place ?? null))
                                    ->id('death_place')->class('form-control' . ($errors->has('death_place') ? ' is-invalid' : '')) !!}
{{--                            {!! Html::hidden('death_place', $celebrity->death_place ?? null) !!}--}}
                            @if($errors->has('death_place'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('death_place') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.celebrity.death_date'), 'death_date')->class('col-form-label'); !!}
                            {!! Html::date('death_date', old('death_date', $celebrity ? ($celebrity->death_date ?? null) : null))
                                    ->class('form-control' . ($errors->has('death_date') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('death_date'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('death_date') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label(__('adminlte.gender'), 'gender')->class('col-form-label') !!}
                            {!! Html::select('gender', \App\Models\Celebrity\Celebrity::gendersList(), old('gender', $celebrity->death_place ?? null))
                                    ->id('gender')->class('form-control' . ($errors->has('gender') ? ' is-invalid' : '')) !!}
                            @if($errors->has('gender'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('gender') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.celebrity.height_meter'), 'height_meter')->class('col-form-label'); !!}
                            {!! Html::number('height_meter', old('height_meter', $celebrity ? ($celebrity->height_meter ?? null) : null))
                                    ->class('form-control' . ($errors->has('height_meter') ? ' is-invalid' : ''))->attribute('step', '0.01') !!}
                            @if ($errors->has('height_meter'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('height_meter') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.celebrity.height_foot'), 'height_foot')->class('col-form-label'); !!}
                            {!! Html::number('height_foot', old('height_foot', $celebrity ? ($celebrity->height_foot ?? null) : null))
                                    ->class('form-control' . ($errors->has('height_foot') ? ' is-invalid' : ''))->attribute('step', '0.01') !!}
                            @if ($errors->has('height_foot'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('height_foot') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-yellow card-outline">
            <div class="card-header"><h3 class="card-title">{{ trans('adminlte.celebrity.social_networks') }}</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label('Twitter', 'twitter')->class('col-form-label') !!} <img src="{{ asset('img/social-networks/twitter-round-24x24.png') }}" alt="Twitter">
                            {!! Html::text('twitter', old('twitter', $celebrity->twitter ?? null))->class('form-control' . ($errors->has('twitter') ? ' is-invalid' : '')) !!}
                            @if($errors->has('twitter'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('twitter') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label('Facebook', 'facebook')->class('col-form-label') !!} <img src="{{ asset('img/social-networks/facebook-24x24.png') }}" alt="Facebook">
                            {!! Html::text('facebook', old('facebook', $celebrity->facebook ?? null))->class('form-control' . ($errors->has('facebook') ? ' is-invalid' : '')) !!}
                            @if($errors->has('facebook'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('facebook') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label('Instagram', 'instagram')->class('col-form-label') !!} <img src="{{ asset('img/social-networks/instagram-filled-24x24.png') }}" alt="Instagram">
                            {!! Html::text('instagram', old('instagram', $celebrity->instagram ?? null))->class('form-control' . ($errors->has('instagram') ? ' is-invalid' : '')) !!}
                            @if($errors->has('instagram'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('instagram') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label('Youtube', 'youtube')->class('col-form-label') !!} <img src="{{ asset('img/social-networks/youtube-big-24x24.png') }}" alt="Youtube">
                            {!! Html::text('youtube', old('youtube', $celebrity->youtube ?? null))->class('form-control' . ($errors->has('youtube') ? ' is-invalid' : '')) !!}
                            @if($errors->has('youtube'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('youtube') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label('Google Plus', 'google_plus')->class('col-form-label') !!} <img src="{{ asset('img/social-networks/google-plus-24x24.png') }}" alt="Google plus">
                            {!! Html::text('google_plus', old('google_plus', $celebrity->google_plus ?? null))->class('form-control' . ($errors->has('google_plus') ? ' is-invalid' : '')) !!}
                            @if($errors->has('google_plus'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('google_plus') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Html::label('Linkedin', 'linkedin')->class('col-form-label') !!} <img src="{{ asset('img/social-networks/linkedin-24x24.png') }}" alt="Linkedin">
                            {!! Html::text('linkedin', old('linkedin', $celebrity->linkedin ?? null))->class('form-control' . ($errors->has('linkedin') ? ' is-invalid' : '')) !!}
                            @if ($errors->has('linkedin'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('linkedin') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-gray-dark card-outline">
            <div class="card-header"><h3 class="card-title">SEO</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.title'), 'meta_title')->class('col-form-label'); !!}
                            {!! Html::text('meta_title', old('meta_title', $celebrity ? $celebrity->meta_json->title : null))
                                    ->class('form-control' . ($errors->has('meta_title') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('meta_title'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('meta_title') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.keywords'), 'meta_keywords')->class('col-form-label'); !!}
                            {!! Html::text('meta_keywords', old('meta_keywords', $celebrity ? $celebrity->meta_json->keywords : null))
                                     ->class('form-control' . ($errors->has('meta_title') ? ' is-invalid' : ''))->required() !!}
                            @if ($errors->has('meta_keywords'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('meta_keywords') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Html::label(trans('adminlte.description'), 'meta_description')->class('col-form-label'); !!}
                            {!! Html::textarea('meta_description', old('meta_description', $celebrity ? $celebrity->meta_json->description : null))
                                ->class('form-control' . $errors->has('meta_description') ? ' is-invalid' : '')
                                ->id('meta_description')->rows(10)->required() !!}
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
    <button type="submit" class="btn btn-primary">{{ trans('adminlte.' . ($celebrity ? 'edit' : 'save')) }}</button>
</div>

@include('admin.celebrity.celebrities._js')
