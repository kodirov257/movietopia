<x-admin-page-layout>
    @section('content')
        <form action="{{ route('dashboard.celebrities.quotes.update', ['celebrity' => $celebrity, 'quote' => $quote]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('partials.admin._nav')

            @include('admin.celebrity.quotes._form')
        </form>
    @endsection
</x-admin-page-layout>
