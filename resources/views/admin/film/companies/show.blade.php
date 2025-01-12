<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.films.companies.edit', ['film' => $film, 'company' => $company]) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <p><a href="{{ route('dashboard.films.companies.release-dates.create', ['film' => $film, 'company' => $company]) }}" class="btn btn-secondary">{{ __('adminlte.film.add_release_date') }}</a></p>
            <form method="POST" action="{{ route('dashboard.films.companies.destroy', ['film' => $film, 'company' => $company]) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('{{ trans('adminlte.delete_confirmation_message') }}')">{{ trans('adminlte.delete') }}</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">{{ trans('adminlte.main') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped projects">
                            <tbody>
                            <tr><th>ID</th><td>{{ $company->id }}</td></tr>
                            <tr>
                                <th>{{ __('adminlte.film.company') }}</th>
                                <td>
                                    <a href="{{ route('dashboard.companies.show', $company->company) }}">{{ $company->company->name }}</a>
                                </td>
                            </tr>
                            <tr><th>{{ __('adminlte.type') }}</th><td>{{ $company->type->typeName() }}</td></tr>
                            <tr><th>Tafsilotlari</th><td>{!! $company->details_uz !!}</td></tr>
                            <tr><th>Тафсилотлари</th><td>{!! $company->details_uz_cy !!}</td></tr>
                            <tr><th>Подробности</th><td>{!! $company->details_ru !!}</td></tr>
                            <tr><th>Details</th><td>{!! $company->details_en !!}</td></tr>
                            <tr><th>{{ __('adminlte.date') }}</th><td>{{ $company->date->format('Y-m-d') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">{{ trans('adminlte.other') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped projects">
                            <tbody>
                            <tr>
                                <th>{{ trans('adminlte.created_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $company->createdBy) }}">{{ $company->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $company->updatedBy) }}">{{ $company->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $company->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $company->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="release-dates">
            <div class="card-header card-gray with-border">{{ __('menu.release_dates') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.films.companies.release-dates.create', ['film' => $film, 'company' => $company]) }}" class="btn btn-success">{{ __('adminlte.film.add_release_date') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminlte.release-date') }}</th>
                        <th>Tafsilotlari</th>
                        <th>Подробности</th>
                        <th>Details</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($company->releaseDates as $releaseDate)
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.films.companies.release-dates.show', ['film' => $film, 'company' => $company, 'release_date' => $releaseDate]) }}">
                                    {{ $releaseDate->release_date }}
                                </a>
                            </td>
                            <td>{{ custom_substr($releaseDate->details_uz) }}</td>
                            <td>{{ custom_substr($releaseDate->details_ru) }}</td>
                            <td>{{ custom_substr($releaseDate->details_en) }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <form method="POST" action="{{ route('dashboard.films.companies.release-dates.first', ['film' => $film, 'company' => $company, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.companies.release-dates.up', ['film' => $film, 'company' => $company, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.companies.release-dates.down', ['film' => $film, 'company' => $company, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.films.companies.release-dates.last', ['film' => $film, 'company' => $company, 'releaseDate' => $releaseDate]) }}" class="mr-1">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                                    </form>
                                </div>
                            </td>
                            <td><a href="{{ route('dashboard.films.companies.release-dates.show', ['film' => $film, 'company' => $company, 'release_date' => $releaseDate]) }}">Show</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
