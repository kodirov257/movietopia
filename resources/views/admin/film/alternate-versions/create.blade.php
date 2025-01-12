<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.alternate-versions.store', $film) }}" method="POST">
            @csrf

            @include('admin.film.alternate-versions._form', ['alternateVersion' => null])
        </form>
    @endsection
</x-admin-page-layout>
