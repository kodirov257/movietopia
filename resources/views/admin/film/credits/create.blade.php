<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.credits.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.credits._form', ['credit' => null])
        </form>
    @endsection
</x-admin-page-layout>
