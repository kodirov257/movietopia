<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.genres.store') }}" method="POST">
            @csrf

            @include('admin.genres._form', ['genre' => null])
        </form>
    @endsection
</x-admin-page-layout>
