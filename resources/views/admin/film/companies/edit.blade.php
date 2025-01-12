<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.companies.update', ['film' => $film, 'company' => $company]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.film.companies._form')
        </form>
    @endsection
</x-admin-page-layout>
