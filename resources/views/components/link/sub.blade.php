@props(['href' , 'can'=>null])
@can($can)
    <a href="{{$href}}" class="hover:bg-zinc-300 p-1 rounded-full hover:cursor-pointer">
        <i class="tkicon fill-none stroke-orange-600" data-icon="inbox" size="18" stroke-width="2"></i>
    </a>
@endcan
