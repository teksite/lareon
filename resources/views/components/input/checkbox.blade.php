@props(["disabled"=>false ,'required'=>false ,'value'=>null , 'checked'=>false])
<input type="checkbox" {{$disabled ? 'disabled':''}} {{$attributes->merge(['class'=>'border border-zinc-300 px-3 py-1 rounded outline-none accent-green-600' ])}} @checked($checked) @required($required) value="{{$value}}">
