<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

{{--            @include('partials.admin._nav')--}}

            @include('admin.film.films._form', ['film' => null])
        </form>
    @endsection
</x-admin-page-layout>
