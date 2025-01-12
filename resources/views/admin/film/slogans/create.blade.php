<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.slogans.store', $film) }}" method="POST">
            @csrf

            @include('admin.film.slogans._form', ['slogan' => null])
        </form>
    @endsection
</x-admin-page-layout>
