<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.companies.release-dates.store', ['film' => $film, 'company' => $company]) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.film.film-company-release-dates._form', ['releaseDate' => null])
        </form>
    @endsection
</x-admin-page-layout>
