<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.countries.store') }}" method="POST">
            @csrf

            @include('admin.countries._form', ['country' => null])
        </form>
    @endsection
</x-admin-page-layout>
