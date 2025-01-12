<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.release-dates.update', ['film' => $film, 'release_date' => $releaseDate]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.film-release-dates._form')
        </form>
    @endsection
</x-admin-page-layout>
