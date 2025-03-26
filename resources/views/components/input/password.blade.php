@props(['value'=>null , "disabled"=>false ,'required'=>false ,'name' =>'password' ,'placeholder'=>null])
<div x-data="{show:false}" @click.outside="show=false" {{$attributes->except('id')->merge(['class'=>'input flex items-center justify-between' ])}} >
    <input name="{{$name}}" class="w-full outline-none " id="{{$attributes->get('id')}}" x-bind:type="show ? 'text' :'password'" {{$disabled ? 'disabled':''}}  @required($required) value="{{$value}}" autocomplete="new-password" placeholder="{{$placeholder}}">
    <button class="min-w-fit" role="switch" type="button" @click="show= !show">
        <i class="tkicon" :class="{ 'hidden': show, 'block': !show }" data-icon="eye" size="16"></i>
        <i class="tkicon" :class="{ 'hidden': !show, 'block': show }" data-icon="eye-banned" size="16"></i>
    </button>
</div>
