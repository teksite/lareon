@props(['instance'=>null , 'multiple'=>true ,'hierarchy'=>true])
@php

$roles=\Lareon\CMS\App\Models\User::hierarchyRoles();
$random='roles-select'.rand(1000,9999);
@endphp
<x-lareon::box>
    <x-lareon::input.label for="{{$random}}" :title="__('roles')"/>
    <x-lareon::input.select name="roles[]" id="{{$random}}" :multiple="$multiple" class="block w-full">
        @foreach($roles as $role)
            <option
                value="{{$role->id}}" @selected(old('roles') ? in_array($role->id , old('roles')) : ($instance &&  in_array($role->id , $instance->roles->pluck('id')->toArray())))>
                {{$role->title}}
            </option>
        @endforeach
    </x-lareon::input.select>
    <x-lareon::input.error :messages="$errors->get('roles')"/>
    <x-lareon::input.error :messages="$errors->get('roles.*')"/>

</x-lareon::box>
