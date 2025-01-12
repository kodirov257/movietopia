<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.storyline.update', $film) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.storyline._form')
        </form>
    @endsection
</x-admin-page-layout>
