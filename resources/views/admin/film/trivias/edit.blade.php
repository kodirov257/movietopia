<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.trivias.update', ['film' => $film, 'trivia' => $trivia]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.trivias._form')
        </form>
    @endsection
</x-admin-page-layout>
