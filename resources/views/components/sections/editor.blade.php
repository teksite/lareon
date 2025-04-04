@props(['name' ,'title' , 'placeholder'=>null, 'required'=>false , 'type'=>'text' ,'open'=>false ,'accordion'=>true] )
@php
    $random='textarea__'.strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=dotToArray($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp
<x-lareon::accordion.box :title="__($title)" :open="$open" :accordion="$accordion">
    <x-lareon::input.textarea :name="$name" id="{{$random}}" placeholder="{{$placeholder}}" :required="$required" {{$attributes}}>{{$slot ?? ''}}</x-lareon::input.textarea>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>
</x-lareon::accordion.box>
