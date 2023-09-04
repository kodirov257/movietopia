<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.update', $celebrity) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.celebrity.celebrities._form')
        </form>
    @endsection
</x-admin-page-layout>
