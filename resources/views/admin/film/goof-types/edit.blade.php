<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.goof-types.update', $goofType) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.film.goof-types._form')
        </form>
    @endsection
</x-admin-page-layout>
