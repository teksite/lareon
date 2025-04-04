@props(['type'=>'submit' , 'color'=>null])
@php
    $class=match ($color){
        'red'=>'bg-red-600 hover:bg-red-900 text-gray-50',
        'yellow'=>'bg-yellow-600 hover:bg-yellow-900',
        'green'=>'bg-green-600 hover:bg-green-900 text-gray-50',
        'violet'=>'bg-violet-600 hover:bg-violet-900 text-gray-50',
        'white'=>'bg-white hover:bg-slate-50 text-blue-600',
        default=> 'bg-blue-600 hover:bg-blue-900 text-gray-50',
    };
@endphp
<button type="{{$type}}" {{$attributes->merge(['class'=> "rounded text-sm px-3 py-2 shadow font-semibold hover:cursor-pointer select-none $class"])}}>
    {!! $slot !!}
</button>
