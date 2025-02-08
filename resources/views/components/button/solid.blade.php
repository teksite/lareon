@props(['type'=>'submit' , 'color'=>'blue'])

<button type="{{$type}}" @class([
    'text-gray-50 rounded-lg text-sm px-3 py-1 shadow hover:cursor-pointer',
    'bg-blue-600' => $color==='blue',
    'bg-red-600' => $color==='red',
    'bg-yellow-600' => $color==='yellow',
])>
{!! $slot !!}
</button>
