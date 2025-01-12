<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.goofs.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.goofs._form', ['goof' => null])
        </form>
    @endsection
</x-admin-page-layout>
