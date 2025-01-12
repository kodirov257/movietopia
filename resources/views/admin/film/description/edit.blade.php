<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.description.update', $film) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.description._form')
        </form>
    @endsection
</x-admin-page-layout>
