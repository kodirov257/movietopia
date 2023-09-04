<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.biography.update', $celebrity) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.celebrity.biography._form')
        </form>
    @endsection
</x-admin-page-layout>
