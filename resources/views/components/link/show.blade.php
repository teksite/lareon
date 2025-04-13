@props(['href' , 'can'=>null ,'target'=>'_blank'])
@can($can)
    <a href="{{$href}}" class="hover:bg-zinc-300 p-1 rounded-full hover:cursor-pointer" target="{{$target}}">
        <i class="tkicon fill-none stroke-green-600" data-icon="eye" size="18" stroke-width="2"></i>
    </a>
@endcan
