@props(['name' ,'title', 'required'=>false ,'open'=>false ,'accordion'=>true ,"multiple"=>false , 'selected'=>[], 'model' ,'dataLabel' ,'dataValue' ,'dataSearch' ,'url','model' ] )
@php
    $random='select_dynamic__'.strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=arrayToDot($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
    $data=old($stringifiedName) ??  $selected ?? [];
    $items=(new $model)->query()->whereIn('id',$data)->select([$dataValue ,$dataSearch])->get();

@endphp

<div>
    <x-lareon::accordion.box :title="__($title)" :open="$open" :accordion="$accordion">
    <x-lareon::input.select
        data-value-field="{{$dataValue}}" data-label-field="{{$dataLabel}}" data-search-field="{{$dataSearch}}" data-url="{{$url}}"
        :name="$name" id="{{$random}}" :required="$required" {{$attributes->merge(['class'=>'ajax_select'])}} :multiple="$multiple">
        @foreach($items as $item)
            <option value="{{$item->$dataValue ?? $item[$dataValue]}}" selected>{{$item->$dataSearch ?? $item[$dataSearch]}}</option>
        @endforeach
    </x-lareon::input.select>
    </x-lareon::accordion.box>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>

</div>
