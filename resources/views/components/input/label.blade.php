@props(['title'=>null])
<label {{$attributes->merge(['class'=>'text-zinc-600 font-bold text-sm mb-1 block' ])}}>
{!! $title ?? $slot ?? '' !!}
</label>
