<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.countries.update', $country) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.countries._form')
        </form>
    @endsection
</x-admin-page-layout>
