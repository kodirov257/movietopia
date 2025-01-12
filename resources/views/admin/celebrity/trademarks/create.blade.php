<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.trademarks.store', $celebrity) }}" method="POST">
            @csrf

            @include('partials.admin._nav')

            @include('admin.celebrity.trademarks._form', ['trademark' => null])
        </form>
    @endsection
</x-admin-page-layout>
