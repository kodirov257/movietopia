<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.companies.update', $company) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.companies._form')
        </form>
    @endsection
</x-admin-page-layout>
