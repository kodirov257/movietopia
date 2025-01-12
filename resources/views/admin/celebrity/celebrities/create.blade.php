<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('partials.admin._nav')

            @include('admin.celebrity.celebrities._form', ['celebrity' => null])
        </form>
    @endsection
</x-admin-page-layout>
