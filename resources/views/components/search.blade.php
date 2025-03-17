<form action="" method="GET" class="relative">
    <div class="flex gap-1 items-center border border-zinc-300 ps-3 py-1 rounded focus:outline-2 focus:outline-blue-600 bg-transparent w-full">
        <input type="text" name="s" class="block w-full outline-none" value="{{request()->input('s' ,'')}}" placeholder="{{__('search')}}...">
        <div class="flex items-center ">
            <button type="submit" role="button" title="{{__('search')}}" class="min-w-fit border-s px-3 border-zinc-300 hover:cursor-pointer">
                <i class="tkicon" data-icon="magnifier" size="20"></i>
            </button>
            @if(request()->s)
                <a href="{{request()->fullUrlWithoutQuery(['s'])}}" title="{{__('all')}}" class="min-w-fit text-sm font-semibold border-s ps-3 border-zinc-300 px-3 hover:cursor-pointer">
                    {{__('all')}}
                </a>
            @endif
        </div>
    </div>
</form>
