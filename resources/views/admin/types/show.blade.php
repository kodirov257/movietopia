<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.types.edit', $type) }}" class="btn btn-primary mr-1">{{ __('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.types.destroy', $type) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('{{ __('adminlte.delete_confirmation_message') }}')">{{ __('adminlte.delete') }}</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('adminlte.main') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped projects">
                            <tbody>
                            <tr><th>ID</th><td>{{ $type->id }}</td></tr>
                            <tr><th>Nomi</th><td>{{ $type->name_uz }}</td></tr>
                            <tr><th>Номи</th><td>{{ $type->name_uz_cy }}</td></tr>
                            <tr><th>Название</th><td>{{ $type->name_ru }}</td></tr>
                            <tr><th>Name</th><td>{{ $type->name_en }}</td></tr>
                            <tr><th>{{ __('adminlte.type') }}</th><td>{{ $type->typeName() }}</td></tr>
                            <tr><th>Slug</th><td>{{ $type->slug }}</td></tr>
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
                            <tr><th>{{ __('adminlte.title') }}</th><td>{{ $type->meta_json->title }}</td></tr>
                            <tr><th>{{ __('adminlte.keywords') }}</th><td>{{ $type->meta_json->keywords }}</td></tr>
                            <tr><th>{{ __('adminlte.description') }}</th><td>{{ $type->meta_json->description }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-gray card-outline">
                    <div class="card-header"><h3 class="card-title">{{ __('adminlte.other') }}</h3></div>
                    <div class="card-body">
                        <table class="table table-striped projects">
                            <tbody>
                            <tr>
                                <th>{{ __('adminlte.created_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $type->createdBy) }}">{{ $type->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ __('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $type->updatedBy) }}">{{ $type->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ __('adminlte.created_at') }}</th><td>{{ $type->created_at }}</td></tr>
                            <tr><th>{{ __('adminlte.updated_at') }}</th><td>{{ $type->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
