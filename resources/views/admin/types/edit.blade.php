<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.types.update', $type) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.types._form')
        </form>
    @endsection
</x-admin-page-layout>
