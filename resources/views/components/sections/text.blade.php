@props(['name' ,'title' , 'placeholder'=>null ,'value'=>null , 'required'=>false])
@php
    $random=strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    if(str_contains($name , '[' )){
    $stringifyName=str_replace('][','.', $name);
    $stringifyName=str_replace('[','.', $stringifyName);
    $stringifyName=str_replace(']','', $stringifyName);
    }else{
        $stringifyName=$name;
    }
@endphp

<div class="mb-3">
    <x-lareon::input.label for="{{$random}}" :title="$title"/>
    <x-lareon::input.text  :name="$name" id="{{$random}}" placeholder="{{$placeholder}}" :value="old($stringifyName)?? $value" :required="true"/>
    <x-lareon::input.error :messages="$errors->get($stringifyName)"/>
</div>
