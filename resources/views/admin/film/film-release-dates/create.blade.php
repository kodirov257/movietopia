<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.release-dates.store', ['film' => $film]) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.film-release-dates._form', ['releaseDate' => null])
        </form>
    @endsection
</x-admin-page-layout>
