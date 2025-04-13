@props(['name' ,'title' , 'value'=>null , 'required'=>false , 'type'=>'text'] )
@php
    $random="check__".strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=dotToArray($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp
<div class="mb-3">
    <div class="mb-3 flex gap-3">
        <x-lareon::input.checkbox :type="$type ?? 'text'" :name="$name" id="{{$random}}"  :value="$value" :required="$required" {{$attributes}}/>
        <x-lareon::input.label for="{{$random}}" :title="$title . $requiredMark" class="!mb-0"/>
    </div>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>

</div>
