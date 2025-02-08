@props(['title'=>null])
<label {{$attributes->merge(['class'=>'text-zinc-600 font-bold text-sm' ])}}>
{!! $title ?? $slot ?? '' !!}
</label>
