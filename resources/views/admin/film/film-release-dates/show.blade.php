<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.films.release-dates.edit', ['film' => $film, 'release_date' => $releaseDate]) }}" class="btn btn-primary mr-1">
                {{ trans('adminlte.edit') }}
            </a>
            <form method="POST" action="{{ route('dashboard.films.release-dates.destroy', ['film' => $film, 'release_date' => $releaseDate]) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $releaseDate->id }}</td></tr>
                            <tr>
                                <th>{{ __('movie.film.film') }}</th>
                                <td>
                                    <a href="{{ route('dashboard.films.show', $film) }}">{{ $film->title }}</a>
                                </td>
                            </tr>
                            <tr><th>Tafsilotlari</th><td>{!! $releaseDate->details_uz !!}</td></tr>
                            <tr><th>Тафсилотлари</th><td>{!! $releaseDate->details_uz_cy !!}</td></tr>
                            <tr><th>Подробности</th><td>{!! $releaseDate->details_ru !!}</td></tr>
                            <tr><th>Details</th><td>{!! $releaseDate->details_en !!}</td></tr>
                            <tr><th>{{ __('adminlte.release-date') }}</th><td>{{ $releaseDate->release_date->format('Y-m-d') }}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $releaseDate->createdBy) }}">{{ $releaseDate->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $releaseDate->updatedBy) }}">{{ $releaseDate->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $releaseDate->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $releaseDate->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
