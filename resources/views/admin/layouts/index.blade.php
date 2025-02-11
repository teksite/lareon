<x-lareon::admin-layout>
    @section('title')
        @yield('title')
    @endsection
    @section('header.end')
        <x-lareon::search/>
    @endsection

    @yield('beforeIndex')
    @yield('index')
    @yield('afterIndex')
</x-lareon::admin-layout>
