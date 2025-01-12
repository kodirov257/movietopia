<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.goofs.update', ['film' => $film, 'goof' => $goof]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.goofs._form')
        </form>
    @endsection
</x-admin-page-layout>
