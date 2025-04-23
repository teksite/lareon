@props(['name' ,'title'=>null , 'required'=>false ,'items'=>[] ,'classBox'=>null ,'checked'=>null] )
@php
    $random="check__".strtolower(\Illuminate\Support\Str::random(4)).rand(1000 ,9999);
    $stringifiedName=dotToArray($name);
    $requiredMark=$required ? ' <span class="text-red-600">*</spam> ' : '';
@endphp
<div class="mb-3">
    @if($title)
        <x-lareon::input.label :title="$title . $requiredMark"/>
    @endif
    <div class="{{$classBox}}">
        @foreach($items as $item)
            <div class="mb-3 flex gap-3">
                <x-lareon::input.radio :name="$name" id="{{$random}}_{{$loop->iteration}}"  :value="$item['value']" :checked="$item['value'] == $checked" />
                <x-lareon::input.label for="{{$random}}_{{$loop->iteration}}" :title="$item['title'] . $requiredMark" class="!mb-0"/>
            </div>
        @endforeach
    </div>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)"/>
</div>
