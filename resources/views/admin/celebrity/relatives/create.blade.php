<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.relatives.store', $celebrity) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.celebrity.relatives._form', ['relative' => null])
        </form>
    @endsection
</x-admin-page-layout>
