<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.trivias.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.trivias._form', ['trivia' => null])
        </form>
    @endsection
</x-admin-page-layout>
