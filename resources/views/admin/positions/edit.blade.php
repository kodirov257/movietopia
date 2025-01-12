<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.positions.update', $position) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.positions._form')
        </form>
    @endsection
</x-admin-page-layout>
