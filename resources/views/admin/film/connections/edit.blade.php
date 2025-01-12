<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.connections.update', ['film' => $film, 'connection' => $connection]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.connections._form')
        </form>
    @endsection
</x-admin-page-layout>
