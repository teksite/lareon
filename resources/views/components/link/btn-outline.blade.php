@props(['href' , 'title' , 'color'=>null ,'can'=>null])
@php
    $class=match ($color){
        'red'=>'border-red-600 hover:bg-red-900 text-red-600 text-red-600',
        'yellow'=>'border-yellow-600 hover:bg-yellow-900 text-yellow-600 text-yellow-600',
        'green'=>'border-green-600 hover:bg-green-900 text-green-600 text-green-600',
        'teal'=>'border-teal-600 hover:bg-teal-900 text-teal-600 text-teal-600',
        'white'=>'border-zinc-600 hover:bg-zinc-900 text-zinc-600 text-zinc-600',
        default=> 'border-blue-600 hover:bg-blue-900 text-blue-600 text-blue-600',
    };
@endphp
@can($can)
    <a href="{{$href}}"
       class="p-1 rounded hover:cursor-pointer py-2 px-3 border font-semibold text-xs hover:text-slate-50 {{$class}}">
        {{$title}}
    </a>
@endcan
