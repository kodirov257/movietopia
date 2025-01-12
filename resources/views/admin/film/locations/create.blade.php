<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.locations.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.locations._form', ['location' => null])
        </form>
    @endsection
</x-admin-page-layout>
