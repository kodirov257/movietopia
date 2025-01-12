<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.languages.update', $position) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.languages._form')
        </form>
    @endsection
</x-admin-page-layout>
