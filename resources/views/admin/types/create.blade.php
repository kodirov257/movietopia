<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.types.store') }}"
              method="POST">
            @csrf

            @include('admin.types._form', ['type' => null])
        </form>
    @endsection
</x-admin-page-layout>
