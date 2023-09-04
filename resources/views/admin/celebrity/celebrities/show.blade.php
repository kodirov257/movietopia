<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.celebrities.edit', $celebrity) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <a href="{{ route('dashboard.celebrities.biography.edit', $celebrity) }}" class="btn btn-primary mr-1">{{ trans('adminlte.celebrity.edit_biography') }}</a>
            <form method="POST" action="{{ route('dashboard.celebrities.destroy', $celebrity) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('{{ trans('adminlte.delete_confirmation_message') }}')">{{ trans('adminlte.delete') }}</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-blue card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><th>ID</th><td>{{ $celebrity->id }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>ShIO</td></tr>
                                    <tr><td>{{ $celebrity->fullName('uz') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>ШИО</td></tr>
                                    <tr><td>{{ $celebrity->fullName('uz_cy') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>ФИО</td></tr>
                                    <tr><td>{{ $celebrity->fullName('ru') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Full Name</td></tr>
                                    <tr><td>{{ $celebrity->fullName('en') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><th>Slug</th><td>{{ $celebrity->slug }}</td></tr>
                                    </tbody>
                                </table>
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
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    @if ($celebrity->photo)
                                        <a href="{{ $celebrity->photoOriginal }}" target="_blank"><img src="{{ $celebrity->photoThumbnail }}"></a>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-green card-outline">
                    <div class="card-header"><h3 class="card-title">{{ trans('adminlte.main') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr><th>{{ __('adminlte.celebrity.birth_name') }}</th><td>{{ $celebrity->birth_name }}</td></tr>
                            <tr><th>{{ __('adminlte.celebrity.original_name') }}</th><td>{{ $celebrity->original_name }}</td></tr>
                            <tr>
                                <th>{{ __('adminlte.celebrity.nicknames') }}</th>
                                <td>{{ !empty($celebrity->nicknames) ? $celebrity->getNicknames() : '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('adminlte.celebrity.live_place') }}</th>
                                <td>{{ $celebrity->live_place ? $celebrity->livePlace->getPlace() : '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('adminlte.celebrity.born') }}</th>
                                <td>
                                    {{
                                        !$celebrity->birth_date || !$celebrity->birth_place ? '' :
                                            __('adminlte.celebrity.birth_date_place', ['date' => $celebrity->birth_date, 'place' => $celebrity->birthPlace->getPlace()])
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('adminlte.celebrity.death') }}</th>
                                <td>
                                    {{
                                        !$celebrity->death_date || !$celebrity->death_place ? '' :
                                            __('adminlte.celebrity.birth_date_place', ['date' => $celebrity->death_date, 'place' => $celebrity->deathPlace->getPlace()]) }}
                                </td>
                            </tr>
                            <tr><th>{{ __('adminlte.gender') }}</th><td>{{ $celebrity->genderName() }}</td></tr>
                            <tr><th>{{ __('adminlte.celebrity.height_meter') }}</th><td>{{ $celebrity->height_meter }}</td></tr>
                            <tr><th>{{ __('adminlte.celebrity.height_foot') }}</th><td>{{ $celebrity->height_foot }}</td></tr>
                            <tr>
                                <th>{{ __('adminlte.celebrity.social_networks') }}</th>
                                <td>
                                    @if($celebrity->twitter)
                                        <a href="{{ $celebrity->twitter }}" target="_blank">
                                            <img src="{{ asset('img/social-networks/twitter-round-24x24.png') }}" alt="Twitter">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/social-networks/twitter-round-24x24.png') }}" alt="Twitter">
                                    @endif

                                    @if($celebrity->facebook)
                                        <a href="{{ $celebrity->facebook }}" target="_blank">
                                            <img src="{{ asset('img/social-networks/facebook-24x24.png') }}" alt="Facebook">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/social-networks/facebook-24x24.png') }}" alt="Facebook">
                                    @endif

                                    @if($celebrity->instagram)
                                        <a href="{{ $celebrity->instagram }}" target="_blank">
                                            <img src="{{ asset('img/social-networks/instagram-filled-24x24.png') }}" alt="Instagram">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/social-networks/instagram-filled-24x24.png') }}" alt="Instagram">
                                    @endif

                                    @if($celebrity->google_plus)
                                        <a href="{{ $celebrity->google_plus }}" target="_blank">
                                            <img src="{{ asset('img/social-networks/google-plus-24x24.png') }}" alt="Google plus">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/social-networks/google-plus-24x24.png') }}" alt="Google plus">
                                    @endif

                                    @if($celebrity->youtube)
                                        <a href="{{ $celebrity->youtube }}" target="_blank">
                                            <img src="{{ asset('img/social-networks/youtube-big-24x24.png') }}" alt="Youtube">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/social-networks/youtube-big-24x24.png') }}" alt="Youtube">
                                    @endif

                                    @if($celebrity->linkedin)
                                        <a href="{{ $celebrity->linkedin }}" target="_blank">
                                            <img src="{{ asset('img/social-networks/linkedin-24x24.png') }}" alt="Linkedin">
                                        </a>
                                    @else
                                        <img src="{{ asset('img/social-networks/linkedin-24x24.png') }}" alt="Linkedin">
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-red card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('adminlte.celebrity.profession') }}</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Kasbi</td></tr>
                                    <tr><td>{{ $celebrity->getProfessions('uz') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Касби</td></tr>
                                    <tr><td>{{ $celebrity->getProfessions('uz_cy') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Профессия</td></tr>
                                    <tr><td>{{ $celebrity->getProfessions('ru') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Биография</td></tr>
                                    <tr><td>{{ $celebrity->getProfessions('en') }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-lightblue card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('adminlte.celebrity.biography') }}</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Biografiyasi</td></tr>
                                    <tr><td>{!! $celebrity->biography_uz !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Биографияси</td></tr>
                                    <tr><td>{!! $celebrity->biography_uz_cy !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Биография</td></tr>
                                    <tr><td>{!! $celebrity->biography_ru !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Biography</td></tr>
                                    <tr><td>{!! $celebrity->biography_en !!}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($celebrity->meta_json))
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray-dark card-outline">
                        <div class="card-header"><h3 class="card-title">SEO</h3></div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                <tr><th>{{ trans('adminlte.title') }}</th><td>{{ $celebrity->meta_json->title }}</td></tr>
                                <tr><th>{{ trans('adminlte.keywords') }}</th><td>{{ $celebrity->meta_json->keywords }}</td></tr>
                                <tr><th>{{ trans('adminlte.description') }}</th><td>{{ $celebrity->meta_json->description }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">{{ trans('adminlte.other') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>{{ trans('adminlte.created_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $celebrity->createdBy) }}">{{ $celebrity->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $celebrity->updatedBy) }}">{{ $celebrity->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $celebrity->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $celebrity->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="relatives">
            <div class="card-header card-gray with-border">{{ __('menu.celebrity_relatives') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.celebrities.relatives.create', $celebrity) }}" class="btn btn-success">{{ __('adminlte.celebrity.add_relative') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminlte.full_name') }}</th>
                        <th>{{ __('adminlte.celebrity.relation_type') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($celebrity->relatives as $relative)
                        <tr>
                            <td>
                                @if($relative->relative_id)
                                    <a href="{{ route('dashboard.celebrities.show', $relative->relative) }}">{{ $relative->relative->fullName }}</a>
                                @else
                                    {{ $relative->fullName }}
                                @endif
                            </td>
                            <td>{{ $relative->relativeTypeName()}}</td>
                            <td><a href="{{ route('dashboard.celebrities.relatives.show', ['celebrity' => $celebrity, 'relative' => $relative]) }}">Show</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="trademarks">
            <div class="card-header card-gray with-border">{{ __('menu.trademarks') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.celebrities.trademarks.create', $celebrity) }}" class="btn btn-success">{{ __('adminlte.celebrity.add_trademark') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Qiziqarli faktlar</th>
                        <th>Интересные факты</th>
                        <th>Interesting facts</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($celebrity->trademarks as $trademark)
                        <tr>
                            <td>{{ $trademark->trademark_uz }}</td>
                            <td>{{ $trademark->trademark_ru }}</td>
                            <td>{{ $trademark->trademark_en }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.celebrities.trademarks.first', ['celebrity' => $celebrity, 'trademark' => $trademark]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.trademarks.up', ['celebrity' => $celebrity, 'trademark' => $trademark]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.trademarks.down', ['celebrity' => $celebrity, 'trademark' => $trademark]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.trademarks.last', ['celebrity' => $celebrity, 'trademark' => $trademark]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.celebrities.trademarks.show', ['celebrity' => $celebrity, 'trademark' => $trademark]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="trivias">
            <div class="card-header card-gray with-border">{{ __('menu.trivias') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.celebrities.trivias.create', $celebrity) }}" class="btn btn-success">{{ __('adminlte.celebrity.add_trivia') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Mish-mishlar</th>
                        <th>Слухи</th>
                        <th>Trivia</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($celebrity->trivia as $trivia)
                        <tr>
                            <td>{{ substr($trivia->trivia_uz, 0, 200) }}...</td>
                            <td>{{ substr($trivia->trivia_ru, 0, 200) }}...</td>
                            <td>{{ substr($trivia->trivia_en, 0, 200) }}...</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.celebrities.trivias.first', ['celebrity' => $celebrity, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.trivias.up', ['celebrity' => $celebrity, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.trivias.down', ['celebrity' => $celebrity, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.trivias.last', ['celebrity' => $celebrity, 'trivia' => $trivia]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.celebrities.trivias.show', ['celebrity' => $celebrity, 'trivia' => $trivia]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="quotes">
            <div class="card-header card-gray with-border">{{ __('menu.quotes') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.celebrities.quotes.create', $celebrity) }}" class="btn btn-success">{{ __('adminlte.celebrity.add_quote') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Iqtoboslari</th>
                        <th>Цитаты</th>
                        <th>Quotes</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($celebrity->quotes as $quote)
                        <tr>
                            <td>{{ substr($quote->quote_uz, 0, 200) }}...</td>
                            <td>{{ substr($quote->quote_ru, 0, 200) }}...</td>
                            <td>{{ substr($quote->quote_en, 0, 200) }}...</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.celebrities.quotes.first', ['celebrity' => $celebrity, 'quote' => $quote]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.quotes.up', ['celebrity' => $celebrity, 'quote' => $quote]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.quotes.down', ['celebrity' => $celebrity, 'quote' => $quote]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.celebrities.quotes.last', ['celebrity' => $celebrity, 'quote' => $quote]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.celebrities.quotes.show', ['celebrity' => $celebrity, 'quote' => $quote]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
