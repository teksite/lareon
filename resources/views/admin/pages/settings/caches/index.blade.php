<x-lareon::admin-layout>
    @section('title', __(':title list',['title'=>__('caches')]))
    @section('description', __('cache stores frequently accessed data temporarily to speed up application loading and reduce server load'))
    <div class="gap-6 grid md:grid-cols-2">
        @foreach($caches as $name=>$cache)
            <x-lareon::box class="">
                <h3 class="mb-3 text-center">
                    {{$name}}
                </h3>
                @foreach($cache as $command)
                    <div class="flex items-center gap-3 justify-between mb-3">
                        <div class="">
                        <span class="text-lg font-black">
                            {{$command['name']}}
                        </span>
                            <p class="text-sm text-zinc-600">
                                {{__($command['desc'])}}
                            </p>
                        </div>
                        <form class="justify-self-end block" method="POST" action="{{route('admin.settings.caches.run')}}">
                            <input type="hidden" class="hidden" value="{{$name.'.'.$command['name']}}" name="command">
                            @csrf
                            <button type="submit" role="button" title="{{$command['type']}}" class="cursor-pointer deltfrmItms">
                                @if($command['type']==='store')
                                    <i class="tkicon stroke-blue-600" data-icon="box-arrow-in" size="20"></i>
                                @else
                                    <i class="tkicon stroke-red-600" data-icon="trash" size="20"></i>
                                @endif
                            </button>
                        </form>

                    </div>
                    @if(!$loop->last)
                        <hr class="border-dotted border-slate-300 w-full">
                    @endif
                @endforeach
            </x-lareon::box>
        @endforeach
    </div>
</x-lareon::admin-layout>
