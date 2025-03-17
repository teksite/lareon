@props(['value'=>null , "disabled"=>false ,'required'=>false])
<div x-data="{show:false}" @@click.outside="show=false" {{$attributes->merge(['class'=>'input' ])}}>
    <input class="w-full outline-none  px-3 py-1 " x-bind:type="show ? 'text' :'password'" {{$disabled ? 'disabled':''}}  @required($required) value="{{$value}}" autocomplete="new-password">
    <button class="min-w-fit" role="switch" type="button" @click="show= !show"><i class="tkicon" data-icon="eye" size="16"></i></button>
</div>
