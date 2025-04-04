@props(['required'=>false ,'open'=>false , 'path'=>'pages/posts/templates' , 'value'=>null ,'accordion'=>false] )
@php
    $random='template__'.strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
    $templatePath=base_path('resources/views/' .$path);
    $files=[];
    if (is_dir($templatePath)){
       $files=collect( \Illuminate\Support\Facades\File::allFiles($templatePath))
        ->map(fn($file)=>str_replace('.blade.php' ,'', $file->getBasename()))->toArray();
    }

@endphp
@if(count($files))
    <x-lareon::accordion.box :title="__('template')" :open="$open" :accordion="$accordion">
        <x-lareon::input.select name="template" id="{{$random}}" :required="$required" {{$attributes}}>
        <option value="" {{old('template', $value) ===null ? 'selected' :'' }}>{{__('default')}}</option>
        @foreach($files as $file)
            <option value="{{$file}}" {{old('template', $value) ===$file ? 'selected' :'' }}>{{$file}}</option>
        @endforeach
        </x-lareon::input.select>
        <x-lareon::input.error :messages="$errors->get('template')"/>
    </x-lareon::accordion.box>
@endif
