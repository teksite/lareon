@props(["disabled"=>false ,'required'=>false ,'value'=>null])
<input type="checkbox" {{$disabled ? 'disabled':''}} {{$attributes->merge(['class'=>'border border-zinc-300 px-3 py-1 rounded focus:outline-2 focus:outline-blue-600 bg-transparent' ])}} @required($required) value="{{$value}}">
