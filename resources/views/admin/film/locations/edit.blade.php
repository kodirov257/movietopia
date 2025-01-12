<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.locations.update', ['film' => $film, 'location' => $location]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.locations._form')
        </form>
    @endsection
</x-admin-page-layout>
