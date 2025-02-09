<x-lareon::admin-layout>
    @section('title')
        @yield('title')
    @endsection
    <div class="grid md:grid-cols-3  gap-6">
        <div class="md:col-span-2 flex flex-col gap-6">
            @yield('index')
        </div>
        <div class="">
            @yield('beforeForm')
            @if(View::hasSection('form'))
                <x-lareon::box>
                    <h2 class="mb-6">
                        {{__('create a new item')}}
                    </h2>
                    <form method="POST" action="@yield('formRoute')" id="createForm">
                        @csrf
                        @yield('form')
                        <div class="flex items-center justify-end mt-6">
                            <x-lareon::button.solid type="submit" role="submit">
                                {{__('add')}}
                            </x-lareon::button.solid>
                        </div>
                    </form>
                </x-lareon::box>
            @endif
            @yield('afterForm')
        </div>
    </div>
</x-lareon::admin-layout>
