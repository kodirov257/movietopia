<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.relatives.update', ['celebrity' => $celebrity, 'relative' => $relative]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.celebrity.relatives._form')
        </form>
    @endsection
</x-admin-page-layout>
