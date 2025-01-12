<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.synopses.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.synopses._form', ['synopsis' => null])
        </form>
    @endsection
</x-admin-page-layout>
