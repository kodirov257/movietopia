<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.credits.update', ['film' => $film, 'credit' => $credit]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.credits._form')
        </form>
    @endsection
</x-admin-page-layout>
