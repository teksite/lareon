@props(['type'=>'text' , "disabled"=>false ,'required'=>false])
@php
$class=$disabled ? 'text-zinc-300 cursor-not-allowed' : ''
@endphp
<textarea {{$disabled ? 'disabled':''}} {{$attributes->merge(['class'=>"input $class" ])}} @required($required)>{{$slot ?? ''}}</textarea>
