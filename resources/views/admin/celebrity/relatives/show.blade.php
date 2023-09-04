<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.celebrities.relatives.edit', ['celebrity' => $celebrity, 'relative' => $relative]) }}"
               class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST"
                  action="{{ route('dashboard.celebrities.relatives.destroy', ['celebrity' => $celebrity, 'relative' => $relative]) }}"
                  class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"
                        onclick="return confirm('{{ trans('adminlte.delete_confirmation_message') }}')">{{ trans('adminlte.delete') }}</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-blue card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $relative->id }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>ShIO</td></tr>
                                    <tr>
                                        <td>
                                            @if($relative->relative_id)
                                                <a href="{{ route('dashboard.celebrities.show', $relative->relative) }}">{{ $relative->relative->fullName('uz') }}</a>
                                            @else
                                                {{ $relative->fullName('uz') }}
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>ШИО</td></tr>
                                    <tr>
                                        <td>
                                            @if($relative->relative_id)
                                                <a href="{{ route('dashboard.celebrities.show', $relative->relative) }}">{{ $relative->relative->fullName('uz_cy') }}</a>
                                            @else
                                                {{ $relative->fullName('uz_cy') }}
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>ФИО</td></tr>
                                    <tr>
                                        <td>
                                            @if($relative->relative_id)
                                                <a href="{{ route('dashboard.celebrities.show', $relative->relative) }}">{{ $relative->relative->fullName('ru') }}</a>
                                            @else
                                                {{ $relative->fullName('ru') }}
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr><td>Full Name</td></tr>
                                    <tr>
                                        <td>
                                            @if($relative->relative_id)
                                                <a href="{{ route('dashboard.celebrities.show', $relative->relative) }}">{{ $relative->relative->fullName('en') }}</a>
                                            @else
                                                {{ $relative->fullName('en') }}
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>{{ __('adminlte.celebrity.relation_type') }}</th>
                                        <td>{{ $relative->relativeTypeName() }}</td>
                                    </tr>
                                    @if(array_key_exists($relative->relation_type, \App\Models\Celebrity\CelebrityRelative::spousesTypesList()))
                                        <tr><th>{{ __('adminlte.celebrity.marry_date') }}</th><td>{{ $relative->marry_date }}</td></tr>
                                        <tr><th>{{ __('adminlte.celebrity.children') }}</th><td>{{ $relative->children }}</td></tr>
                                        <tr><th>{{ __('adminlte.celebrity.divorce_date') }}</th><td>{{ $relative->divorce_date }}</td></tr>
                                        <tr>
                                            <th>{{ __('adminlte.celebrity.divorce_reason') }}</th>
                                            <td>{{ $relative->divorceReasonName() }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                                <td>
                                    <a href="{{ route('dashboard.users.show', $relative->createdBy) }}">{{ $relative->createdBy->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td>
                                    <a href="{{ route('dashboard.users.show', $relative->updatedBy) }}">{{ $relative->updatedBy->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.created_at') }}</th>
                                <td>{{ $relative->created_at }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_at') }}</th>
                                <td>{{ $relative->updated_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
