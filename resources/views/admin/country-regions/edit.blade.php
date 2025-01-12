<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.country-regions.update', $countryRegion) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.country-regions._form')
        </form>
    @endsection
</x-admin-page-layout>
