@props(['type'=>'text' ,'value'=>null , "disabled"=>false ,'required'=>false])
@php
$class=$disabled ? 'text-zinc-300 cursor-not-allowed' : ''
@endphp
<input type="{{$type}}" {{$disabled ? 'disabled':''}} {{$attributes->merge(['class'=>"border border-zinc-300 px-3 py-1 rounded focus:outline-2 focus:outline-blue-600 bg-transparent block w-full $class" ])}} @required($required) value="{{$value}}">
