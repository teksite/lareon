@props(['name' ,'title' , 'placeholder'=>null ,'value'=>null , 'required'=>false] )
@php
    $random=strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
      $stringifiedName=stringifyName($name)

@endphp

<div class="mb-3">
    <x-lareon::input.label for="pass-{{$random}}" :title="$title"/>
    <x-lareon::input.password :name="$name" id="pass-{{$random}}" placeholder="{{$placeholder}}" :value="$value" :required="$required"/>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>
</div>
