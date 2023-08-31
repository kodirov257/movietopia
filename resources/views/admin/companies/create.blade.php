<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.companies.store') }}" method="POST">
            @csrf

            @include('admin.companies._form', ['company' => null])
        </form>
    @endsection
</x-admin-page-layout>
