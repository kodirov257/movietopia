<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.film.trivias.edit', ['film' => $film, 'trivia' => $trivia]) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.film.trivias.destroy', ['film' => $film, 'trivia' => $trivia]) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $trivia->id }}</td></tr>
                            <tr><th>Qiziqarli fakt</th><td>{!! $trivia->trivia_uz !!}</td></tr>
                            <tr><th>Қизиқарли факт</th><td>{!! $trivia->trivia_uz_cy !!}</td></tr>
                            <tr><th>Интересный факт</th><td>{!! $trivia->trivia_ru !!}</td></tr>
                            <tr><th>Interesting fact</th><td>{!! $trivia->trivia_en !!}</td></tr>
                            <tr><th>{{ __('adminlte.type') }}</th><td>{{ $trivia->typeName() }}</td></tr>
                            <tr><th>{{ __('movie.film.is_spoiler') }}</th><td>{{ $trivia->spoiler ? __('movie.yes') : __('movie.on') }}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $trivia->createdBy) }}">{{ $trivia->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $trivia->updatedBy) }}">{{ $trivia->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $trivia->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $trivia->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
