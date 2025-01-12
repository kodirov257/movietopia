<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.genres.update', $genre) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.genres._form')
        </form>
    @endsection
</x-admin-page-layout>
