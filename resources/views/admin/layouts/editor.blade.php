<x-lareon::admin-layout>
    @props(['type'=>'create'])
    @section('title')
        @yield('title')
    @endsection
    <div class="grid md:grid-cols-3 lg:grid-cols-5  gap-6">
        <div class="ms:col-span-2 lg:col-span-4 flex flex-col gap-6">
            <x-lareon::box>
                    <form method="POST" action="@yield('formRoute')" id="createForm">
                        @csrf
                        @if($type=='update')
                            @method('PATCH')
                        @elseif($type=='put')
                            @method('PUT')
                        @elseif($type=='delete')
                            @method('DELETE')
                        @endif
                        @yield('form')
                        <div class="flex items-center justify-end mt-6">
                            <x-lareon::button.solid type="submit" role="submit">
                                {{$type=='update' || $type=='put' ? __('update') : ($type=='delete' ? __('delete') : __('create'))}}
                            </x-lareon::button.solid>
                        </div>
                    </form>
                </x-lareon::box>
            <div class="">
                @yield('aside')
            </div>
        </div>
</x-lareon::admin-layout>
