<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.positions.store') }}" method="POST">
            @csrf

            @include('admin.positions._form', ['position' => null])
        </form>
    @endsection
</x-admin-page-layout>
