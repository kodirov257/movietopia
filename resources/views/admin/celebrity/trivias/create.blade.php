<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.trivias.store', $celebrity) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.celebrity.trivias._form', ['trivia' => null])
        </form>
    @endsection
</x-admin-page-layout>
