<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.slogans.update', ['film' => $film, 'slogan' => $slogan]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.film.slogans._form')
        </form>
    @endsection
</x-admin-page-layout>
