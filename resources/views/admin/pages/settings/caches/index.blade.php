<x-lareon::admin-layout>
    @section('title', __('caches'))
    <div class="grid gap-6 grid-cols-2 inner-container">
        @foreach($caches as $cache=>$actions)
            <x-lareon::box class="flex items-center justify-between gap-6">
                <h3>
                    {{$cache}}
                </h3>
                <div class="flex items-center justify-center gap-6">
                    @if($actions['store'])
                        @can('admin.cache.create')
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" class="hidden" name="type" value="{{$cache}}">
                                <button type="submit" role="button" class="cursor-pointer" title="{{__('store')}}">
                                    <i class="tkicon stroke-blue-600 hover:stroke-2" data-icon="box-arrow-in"
                                       size="18"></i>
                                </button>
                            </form>
                        @endif
                    @endcan
                    @if($actions['destroy'])
                        @can('admin.cache.delete')
                            <form action="" method="POST">
                                @csrf @method('DELETE')
                                <input type="hidden" class="hidden" name="type" value="{{$cache}}">
                                <button type="submit" role="button" class="cursor-pointer" title="{{__('delete')}}">
                                    <i class="tkicon stroke-red-600 hover:stroke-2" data-icon="trash" size="18"></i>
                                </button>
                            </form>
                        @endcan
                    @endif

                </div>
            </x-lareon::box>

        @endforeach
    </div>
</x-lareon::admin-layout>
