<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.companies.release-dates.update', ['film' => $film, 'company' => $company, 'release_date' => $releaseDate]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.film-company-release-dates._form')
        </form>
    @endsection
</x-admin-page-layout>
