<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.country-regions.store', ['parent' => $parent ? $parent->id : null]) }}"
              method="POST">
            @csrf

            @include('admin.country-regions._form', ['countryRegion' => null])
        </form>
    @endsection
</x-admin-page-layout>
