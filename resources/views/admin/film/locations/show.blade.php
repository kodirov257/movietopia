<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.films.locations.edit', ['film' => $film, 'location' => $location]) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.films.locations.destroy', ['film' => $film, 'location' => $location]) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $location->id }}</td></tr>
                            <tr>
                                <th>{{ __('adminlte.film.location') }}</th>
                                <td>
                                    <a href="{{ route('dashboard.country-regions.show', $location->location) }}">{{ $location->location->getPlace() }}</a>
                                </td>
                            </tr>
                            <tr><th>Tafsilotlari</th><td>{!! $location->details_uz !!}</td></tr>
                            <tr><th>Тафсилотлари</th><td>{!! $location->details_uz_cy !!}</td></tr>
                            <tr><th>Подробности</th><td>{!! $location->details_ru !!}</td></tr>
                            <tr><th>Details</th><td>{!! $location->details_en !!}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $location->createdBy) }}">{{ $location->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $location->updatedBy) }}">{{ $location->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $location->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $location->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
