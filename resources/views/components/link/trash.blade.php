@props(['href' , 'can'=>null , 'count'=>0])
@can($can)
    <a href="{{$href}}" class="rounded-full hover:cursor-pointer relative">
        <i class="tkicon fill-none stroke-red-600" data-icon="trash-opened" size="28" stroke-width="2"></i>
        <span class="absolute bottom-0 start-1/2 bg-red-600 w-6 h-6 flex items-center justify-center text-center text-slate-50 rounded-full text-xs font-semibold" >{{$count}}</span>
    </a>
@endcan
