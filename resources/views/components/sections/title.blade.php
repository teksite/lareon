@props(['name'=>'title' , 'placeholder'=>null ,'value'=>null , 'required'=>false ] )
@php
    $random=strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp
<div class="">
    <div class="gap-1 flex items-center">
        <x-lareon::input.label for="{{$random}}" :title="__('title') . $requiredMark" class="min-w-fit w-fit"/>
        <x-lareon::input.text type="text" :name="$name" id="{{$random}}" placeholder="{{$placeholder}}" :value="$value" :required="$required" {{$attributes}}/>
    </div>
    <x-lareon::input.error :messages="get_error($errors , $name)"/>
</div>
