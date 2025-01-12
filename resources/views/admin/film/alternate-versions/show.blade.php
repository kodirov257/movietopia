<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.films.alternate-versions.edit', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.films.alternate-versions.destroy', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $alternateVersion->id }}</td></tr>
                            <tr><th>Versiyasi</th><td>{!! $alternateVersion->version_uz !!}</td></tr>
                            <tr><th>Версияси</th><td>{!! $alternateVersion->version_uz_cy !!}</td></tr>
                            <tr><th>Версия</th><td>{!! $alternateVersion->version_ru !!}</td></tr>
                            <tr><th>Version</th><td>{!! $alternateVersion->version_en !!}</td></tr>
                            <tr><th>{{ __('adminlte.main') }}</th><td>{!! $alternateVersion->main ? __('movie.yes') : __('movie.no') !!}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $alternateVersion->createdBy) }}">{{ $alternateVersion->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $alternateVersion->updatedBy) }}">{{ $alternateVersion->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $alternateVersion->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $alternateVersion->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
