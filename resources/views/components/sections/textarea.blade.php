@props(['name' ,'title' , 'placeholder'=>null ,'value'=>null , 'required'=>false , 'type'=>'text'] )
@php
    $random='textarea__'.strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=dotToArray($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp
<div class="mb-3">
    <x-lareon::input.label for="{{$random}}" :title="$title . $requiredMark"/>
    <x-lareon::input.textarea :type="$type ?? 'text'" :name="$name" id="{{$random}}" placeholder="{{$placeholder}}" :value="$value" :required="$required" {{$attributes}}/>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>
</div>
