<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.synopses.update', ['film' => $film, 'synopsis' => $synopsis]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.synopses._form')
        </form>
    @endsection
</x-admin-page-layout>
