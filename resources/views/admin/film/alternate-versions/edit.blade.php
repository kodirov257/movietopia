<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.alternate-versions.update', ['film' => $film, 'alternate_version' => $alternateVersion]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.film.alternate-versions._form')
        </form>
    @endsection
</x-admin-page-layout>
