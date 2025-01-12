<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.connections.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.connections._form', ['connection' => null])
        </form>
    @endsection
</x-admin-page-layout>
