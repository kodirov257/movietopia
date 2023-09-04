<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.quotes.store', $celebrity) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.celebrity.quotes._form', ['quote' => null])
        </form>
    @endsection
</x-admin-page-layout>
