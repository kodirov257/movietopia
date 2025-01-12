<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.goof-types.store') }}" method="POST">
            @csrf

            @include('admin.film.goof-types._form', ['goofType' => null])
        </form>
    @endsection
</x-admin-page-layout>
