<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.companies.store', $film) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.companies._form', ['company' => null])
        </form>
    @endsection
</x-admin-page-layout>
