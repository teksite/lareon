@props(['type'=>'submit' , 'color'=>'blue'])
@php
    $class=match ($color){
        $color==='red'=>'bg-red-600 hover:bg-red-900',
        $color==='yellow'=>'bg-yellow-600 hover:bg-yellow-900',
        default=> 'bg-blue-600 hover:bg-blue-900',
    };
@endphp
<button type="{{$type}}" {{$attributes->merge(['class'=> "text-gray-50 rounded-lg text-sm px-3 py-2 shadow font-semibold hover:cursor-pointer $class"])}}>
    {!! $slot !!}
</button>
