@props(['multiple'=>true ,'instance'=>null])
@php
    $random='permissions-select'.rand(1000,9999);
    $name=$multiple ? 'permissions[]':'permission'
@endphp
<x-lareon::box>
    <x-lareon::input.label for="{{$random}}" :title="__('permissions')"/>
    <x-lareon::input.select name="{{$name}}" id="{{$random}}" :multiple="$multiple" class="block w-full">
        @foreach(cache()->get('allPermissionsGates') as $permission)
            <option value="{{$permission->id}}" @selected($instance &&  in_array($permission->id , $instance->permissions->pluck('id')->toArray()))>
                {{$permission->title}}
            </option>
        @endforeach
    </x-lareon::input.select>
    <x-lareon::input.error :messages="$errors->get(stringifyName($name))"/>

</x-lareon::box>
