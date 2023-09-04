<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.trivias.update', ['celebrity' => $celebrity, 'trivia' => $trivia]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.celebrity.trivias._form')
        </form>
    @endsection
</x-admin-page-layout>
