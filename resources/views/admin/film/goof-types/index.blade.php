<x-admin-page-layout>
    @section('content')
        <p><a href="{{ route('dashboard.goof-types.create') }}" class="btn btn-success">{{ trans('adminlte.goof_type.add') }}</a></p>

        <div class="card mb-4">
            <div class="card-body">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Html::text('name', request('name'))->class('form-control')->placeholder(trans('adminlte.name')) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Html::button(trans('adminlte.search'), 'submit')->class('btn btn-primary') !!}
                                {!! Html::a('?', trans('adminlte.clear'))->class('btn btn-outline-secondary') !!}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>Nomi</td>
                <td>Название</td>
                <td>Name</td>
                <td>Slug</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($goofTypes as $goofType)
                <tr>
                    <td><a href="{{ route('dashboard.goof-types.show', $goofType) }}">{{ $goofType->name_uz }}</a></td>
                    <td><a href="{{ route('dashboard.goof-types.show', $goofType) }}">{{ $goofType->name_ru }}</a></td>
                    <td><a href="{{ route('dashboard.goof-types.show', $goofType) }}">{{ $goofType->name_en }}</a></td>
                    <td>{{ $goofType->slug }}</td>
                    <td>
                        <div class="d-flex flex-row">
                            <form method="POST" action="{{ route('dashboard.goof-types.first', $goofType) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.goof-types.up', $goofType) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.goof-types.down', $goofType) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.goof-types.last', $goofType) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endsection
</x-admin-page-layout>
