@props(['value'=>[], 'placeholder'=>null, 'required'=>false , 'type'=>'text' ,'open'=>false ,'accordion'=>true] )
@php
    $random='publush__'.strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp

<x-lareon::accordion.box :title="__('publish status')" :open="$open" :accordion="false">

    <x-lareon::input.select id="publishStatus_{{$random}}" class="block mt-1 w-full"  name="publish_status" aria-label="{{__('publish status')}}">
        @foreach(\Lareon\CMS\App\Enums\PublishStatusEnum::cases() as $case)
            <option {{(isset($value[0]) && $value[0] == $case->value) ? 'selected' : ''}} value="{{$case->value}}">{{__($case->value)}}</option>
        @endforeach
    </x-lareon::input.select>
    <x-lareon::input.error :messages="$errors->get('published_status')" class="mt-2"/>
    <br>
    <x-lareon::input.label for="publishAtInput_{{$random}}" :title="__('publish status') . $requiredMark"/>
    <x-lareon::input.time id="publishAtInput_{{$random}}" type="datetime-local" name="published_at" :value="$value[1] ?? ''" class="block w-full" />
    <x-lareon::input.error :messages="$errors->get('published_at')" class="mt-2"/>

</x-lareon::accordion.box>
