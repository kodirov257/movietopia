<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.languages.store') }}" method="POST">
            @csrf

            @include('admin.languages._form', ['language' => null])
        </form>
    @endsection
</x-admin-page-layout>
