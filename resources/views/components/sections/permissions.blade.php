@props(['instance'=>null , 'multiple'=>true ,'hierarchy'=>true])
@php
    $random='permissions-select'.rand(1000,9999);
    $permissions= $hierarchy ? auth()->user()->allPermission() :  cache()->get('allPermissionsGates');
@endphp
<x-lareon::box>
    <x-lareon::input.label for="{{$random}}" :title="__('permissions')"/>
    <x-lareon::input.select name="permissions[]" id="{{$random}}" :multiple="$multiple" class="block w-full">
        @foreach($permissions as $permission)
            <option value="{{$permission->id}}" @selected(in_array($permission->id , old('permissions')??[]) || ($instance &&  in_array($permission->id , $instance->permissions->pluck('id')->toArray())))>
                {{$permission->title}}
            </option>
        @endforeach
    </x-lareon::input.select>
    <x-lareon::input.error :messages="$errors->get('permissions')"/>
    <x-lareon::input.error :messages="$errors->get('permissions.*')"/>

</x-lareon::box>
