<x-admin-page-layout>
    @section('content')
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('dashboard.celebrities.quotes.edit', ['celebrity' => $celebrity, 'quote' => $quote]) }}" class="btn btn-primary mr-1">{{ trans('adminlte.edit') }}</a>
            <form method="POST" action="{{ route('dashboard.celebrities.quotes.destroy', ['celebrity' => $celebrity, 'quote' => $quote]) }}" class="mr-1">
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
                            <tr><th>ID</th><td>{{ $quote->id }}</td></tr>
                            <tr><th>Qiziqarli fakt</th><td>{{ $quote->quote_uz }}</td></tr>
                            <tr><th>Қизиқарли факт</th><td>{{ $quote->quote_uz_cy }}</td></tr>
                            <tr><th>Интересный факт</th><td>{{ $quote->quote_ru }}</td></tr>
                            <tr><th>Interesting fact</th><td>{{ $quote->quote_en }}</td></tr>
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
                                <td><a href="{{ route('dashboard.users.show', $quote->createdBy) }}">{{ $quote->createdBy->name }}</a></td>
                            </tr>
                            <tr>
                                <th>{{ trans('adminlte.updated_by') }}</th>
                                <td><a href="{{ route('dashboard.users.show', $quote->updatedBy) }}">{{ $quote->updatedBy->name }}</a></td>
                            </tr>
                            <tr><th>{{ trans('adminlte.created_at') }}</th><td>{{ $quote->created_at }}</td></tr>
                            <tr><th>{{ trans('adminlte.updated_at') }}</th><td>{{ $quote->updated_at }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-page-layout>
