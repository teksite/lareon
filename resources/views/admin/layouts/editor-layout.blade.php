<x-lareon::admin-layout>
    @props(['type'=>'create' ,'instance'=>null , 'publishStatus'=>true])
    @section('title')@yield('title')@endsection
    @section('description')@yield('description')@endsection

    @section('header.end')
        <x-lareon::button.solid type="submit" role="submit" class="block w-full" onclick="document.getElementById('createForm').submit()" :color="$type ==='update' || $type=='put' ? 'blue' : ($type=='delete' ? __('red') : __('green'))">
            {{$type=='update' || $type=='put' ? __('update') : ($type=='delete' ? __('delete') : __('create'))}}
        </x-lareon::button.solid>
    @endsection

    @yield('beforeForm')

    <form method="POST" action="@yield('formRoute')" id="createForm">
        <div class="grid md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-5 gap-6">
            <div class="md:col-span-2 lg:col-span-1 xl:col-span-4 flex flex-col gap-6">
                <x-lareon::box>
                    @csrf  @if($type=='update') @method('PATCH') @elseif($type=='put') @method('PUT') @elseif($type=='delete') @method('DELETE') @endif
                    @yield('form')
                </x-lareon::box>
                @yield('beforeEndForm')
            </div>
            <div class="flex flex-col gap-6">
                @yield('aside')
                @if($instance)
                    <x-lareon::sections.publish-data :instance="$instance"/>
                @endif
                <div class="mt-3">
                    <x-lareon::button.solid type="submit" role="submit" class="block w-full" :color="$type ==='update' || $type=='put' ? 'blue' : ($type=='delete' ? __('red') : __('green'))">
                        {{$type=='update' || $type=='put' ? __('update') : ($type=='delete' ? __('delete') : __('create'))}}
                    </x-lareon::button.solid>
                </div>
            </div>
        </div>
        @yield('endForm')
    </form>
    @yield('afterForm')

</x-lareon::admin-layout>
