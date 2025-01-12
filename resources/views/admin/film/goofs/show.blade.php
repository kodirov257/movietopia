<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.film.goofs.edit', ['film' => $film, 'goof' => $goof]) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.film.goofs.destroy', ['film' => $film, 'goof' => $goof]) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $goof->id }}</td></tr>
                            <tr><th>Film xatosi</th><td>{!! $goof->goof_uz !!}</td></tr>
                            <tr><th>Филм хатоси</th><td>{!! $goof->goof_uz_cy !!}</td></tr>
                            <tr><th>Ошибка фильма</th><td>{!! $goof->goof_ru !!}</td></tr>
                            <tr><th>Film goof</th><td>{!! $goof->goof_en !!}</td></tr>
                            <tr><th>{{ __('adminlte.type') }}</th><td>{{ $goof->type->name }}</td></tr>
                            <tr><th>{{ __('movie.film.is_spoiler') }}</th><td>{{ $goof->spoiler ? __('movie.yes') : __('movie.on') }}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $goof->createdBy) }}">{{ $goof->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $goof->updatedBy) }}">{{ $goof->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $goof->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $goof->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
