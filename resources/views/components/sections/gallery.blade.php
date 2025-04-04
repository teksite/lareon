@props(['name' ,'title' , 'placeholder'=>null ,'value'=>null , 'required'=>false , 'type'=>'image' ,'preview'=>true, 'size'=>null] )
@php
    $random=strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=dotToArray($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
    $data=match($type){
        'avatar'=>['src'=>'/uploads/admin/avatar-placeholder.jpg' ,'width'=>300 , 'height'=>300],
        'rectangle'=>['src'=>'/uploads/admin/image-rect-placeholder.jpg' ,'width'=>300 , 'height'=>300],
        default=>['src'=>'/uploads/admin/image-placeholder.jpg' ,'width'=>450 , 'height'=>300]
    };
@endphp
<div class="mb-3" xmlns:x-lareon="http://www.w3.org/1999/html">
    <x-lareon::input.label for="input-{{$random}}" :title="$title . $requiredMark . ($size ?? '')"/>
    @if($preview)
        <img id="pre-{{$random}}" src="{{$value ?? $data['src']}}" alt="{{$value}}" loading="lazy" fetchpriority="low" decoding="async" width="{{$data['width']}}" height="{{$data['height']}}">
    @endif
    <x-lareon::input.text type="text" :name="$name" id="input-{{$random}}" placeholder="{{'choose a photo'}}" :value="$value ?? ''" :required="$required"/>
    <x-lareon::button.solid color="violet" class="w-full block" type="button" role="button" :name="$name" id="btn-{{$random}}" placeholder="{{'choose a photo'}}" :value="$value ?? ''" :required="$required">
        {{__('choose')}}
    </x-lareon::button.solid>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>
</div>
