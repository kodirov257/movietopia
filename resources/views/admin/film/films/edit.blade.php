<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.films.update', $celebrity) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

{{--            @include('partials.admin._nav')--}}

            @include('admin.film.films._form')
        </form>
    @endsection
</x-admin-page-layout>
