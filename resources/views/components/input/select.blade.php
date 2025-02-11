@props(['instance'=>null , "disabled"=>false ,'required'=>false ,'multiple'=>false])
<select {{$disabled ? 'disabled':''}} {{$attributes->merge(['class'=>'input' ])}} @required($required) {{$multiple ? 'multiple' : ''}}>
    {!! $slot !!}
</select>
