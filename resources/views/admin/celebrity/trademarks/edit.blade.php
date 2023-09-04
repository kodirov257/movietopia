<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.trademarks.update', ['celebrity' => $celebrity, 'trademark' => $trademark]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.celebrity.trademarks._form')
        </form>
    @endsection
</x-admin-page-layout>
