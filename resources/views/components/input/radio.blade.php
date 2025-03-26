@props(["disabled"=>false ,'required'=>false ,'value'=>null])
<input type="radio" {{$disabled ? 'disabled':''}} {{$attributes->merge(['class'=>'border border-zinc-300 px-3 py-1 rounded outline-none accent-green-600' ])}} @required($required) value="{{$value}}">
