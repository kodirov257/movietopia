<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.genres.edit', $genre) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.genres.destroy', $genre) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $genre->id }}</td></tr>
                            <tr><th>Nomi</th><td>{{ $genre->name_uz }}</td></tr>
                            <tr><th>Номи</th><td>{{ $genre->name_uz_cy }}</td></tr>
                            <tr><th>Название</th><td>{{ $genre->name_ru }}</td></tr>
                            <tr><th>Name</th><td>{{ $genre->name_en }}</td></tr>
                            <tr><th>Slug</th><td>{{ $genre->slug }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">SEO</h3></div>
                    <div class="card-body">
                        <table class="table table-striped projects">
                            <tbody>
                            <tr><th>{{ trans('adminlte.title') }}</th><td>{{ $genre->meta_json->title }}</td></tr>
                            <tr><th>{{ trans('adminlte.keywords') }}</th><td>{{ $genre->meta_json->keywords }}</td></tr>
                            <tr><th>{{ trans('adminlte.description') }}</th><td>{{ $genre->meta_json->description }}</td></tr>
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
                            <tr><th>{{ trans('adminlte.created_by') }}</th><td>{{ $genre->createdBy->name }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_by') }}</th><td>{{ $genre->updatedBy->name }}</td></tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $genre->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $genre->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
