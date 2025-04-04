@props(['name'=>'slug' , 'placeholder'=>null ,'value'=>null , 'required'=>false , 'link'=>null ] )
@php
    $random=strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=dotToArray($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp
<div class="">
    <div class="gap-1 flex items-center">
        <x-lareon::input.label for="{{$random}}" :title="__('slug') . $requiredMark" class="min-w-fit w-fit"/>
        <x-lareon::input.text type="text" :name="$name" id="{{$random}}" placeholder="{{$placeholder}}" :value="$value" :required="$required" {{$attributes}}/>
    </div>
    @if($link)
        <a href="{{$link}}" target="_blank" class="text-sm font-semibold text-blue-600">{{$link}}</a>
    @endif
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>
</div>
