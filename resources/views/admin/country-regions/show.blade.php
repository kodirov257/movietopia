<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.country-regions.edit', $countryRegion) }}" class="btn btn-primary mr-1">{{ __('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.country-regions.destroy', $countryRegion) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $countryRegion->id }}</td></tr>
                            <tr><th>Nomi</th><td>{{ $countryRegion->name_uz }}</td></tr>
                            <tr><th>Номи</th><td>{{ $countryRegion->name_uz_cy }}</td></tr>
                            <tr><th>Название</th><td>{{ $countryRegion->name_ru }}</td></tr>
                            <tr><th>Name</th><td>{{ $countryRegion->name_en }}</td></tr>
                            <tr><th>{{ __('adminlte.type') }}</th><td>{{ $countryRegion->typeName() }}</td></tr>
                            @if($countryRegion->parent)
                                <tr>
                                    <th>{{ __('adminlte.country_region.parent') }}</th>
                                    <td><a href="{{ route('dashboard.country-regions.show', $countryRegion) }}">{{ $countryRegion->parent->name_en }}</a></td>
                                </tr>
                            @endif
                            <tr><th>Slug</th><td>{{ $countryRegion->slug }}</td></tr>
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
                            <tr><th>{{ __('adminlte.title') }}</th><td>{{ $countryRegion->meta_json->title }}</td></tr>
                            <tr><th>{{ __('adminlte.keywords') }}</th><td>{{ $countryRegion->meta_json->keywords }}</td></tr>
                            <tr><th>{{ __('adminlte.description') }}</th><td>{{ $countryRegion->meta_json->description }}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $countryRegion->createdBy) }}">{{ $countryRegion->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ __('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $countryRegion->updatedBy) }}">{{ $countryRegion->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ __('adminlte.created_at') }}</th><td>{{ $countryRegion->created_at }}</td></tr>
                            <tr><th>{{ __('adminlte.updated_at') }}</th><td>{{ $countryRegion->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="states">
            <div class="card-header card-gray with-border">{{ __('menu.regions') }}</div>
            <div class="card-body">
                <p><a href="{{ route('dashboard.country-regions.create', ['parent' => $countryRegion->id]) }}" class="btn btn-success">{{ __('adminlte.country_region.add_region') }}</a></p>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nomi</th>
                        <th>Название</th>
                        <th>Name</th>
                        <th>{{ __('adminlte.type') }}</th>
                        <th>Slug</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($countryRegion->children as $region)
                        <tr>
                            <td><a href="{{ route('dashboard.country-regions.show', $region) }}">{{ $region->name_uz }}</a></td>
                            <td><a href="{{ route('dashboard.country-regions.show', $region) }}">{{ $region->name_ru }}</a></td>
                            <td><a href="{{ route('dashboard.country-regions.show', $region) }}">{{ $region->name_en }}</a></td>
                            <td>{{ $region->typeName() }}</td>
                            <td>{{ $region->slug }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
