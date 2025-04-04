@props(['type'=>'submit' , 'color'=>null , 'value'=>null])
@php

    $class=match ($color){
        'danger'=>'border-red-600 hover:bg-red-900 text-red-600 text-red-600',
        'index'=>'border-teal-600 hover:bg-teal-900 text-teal-600 text-teal-600',
        'create'=>'border-green-600 hover:bg-green-900 text-green-600 text-green-600',
        'update'=> 'border-blue-600 hover:bg-blue-900 text-blue-600 text-blue-600',
        'red'=>'border-red-600 hover:bg-red-900 text-red-600 text-red-600',
        'yellow'=>'border-yellow-600 hover:bg-yellow-900 text-yellow-600 text-yellow-600',
        'green'=>'border-green-600 hover:bg-green-900 text-green-600 text-green-600',
        'teal'=>'border-teal-600 hover:bg-teal-900 text-teal-600 text-teal-600',
        'white'=>'border-zinc-600 hover:bg-zinc-900 text-zinc-600 text-zinc-600',
        default=> 'border-blue-600 hover:bg-blue-900 text-blue-600 text-blue-600',
    };
@endphp
<button
    type="{{$type}}" {{$attributes->merge(['class'=> "border rounded text-sm px-3 py-2 shadow font-semibold hover:cursor-pointer select-none $class"])}}>
    {!! $value ?? $slot !!}
</button>

