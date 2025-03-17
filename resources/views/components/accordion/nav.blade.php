@props(['title', 'icon'=>null ,'is_active'=>false])

@php($id=rand(1000,9999))
<li class="duration-75" x-data="{ isExpanded: @js($is_active ?? false) }">
    <button id="{{$id}}" role="tab" type="button" class="text-sm text-start flex w-full items-center justify-between gap-1" aria-controls="acc-single-{{$id}}" x-on:click="isExpanded = ! isExpanded" x-bind:class="isExpanded ? 'font-bold'  : 'font-medium'" x-bind:aria-expanded="isExpanded ? 'true' : 'false'" x-bind:title="isExpanded ? '{{__('close')}}' : '{{__('open')}}'" >
        <span class="flex justify-between gap-1 items-center">
           @if($icon)
                <i class="tkicon {{$is_active ? 'active' : 'stroke-blue-600'}}" data-icon="{{$icon}}"></i>
           @endif
            <span>
                {{$title}}
            </span>
        </span>
        <i class="tkicon transition-all " data-icon="angle-down" size="14"  aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''"></i>
    </button>
    <div x-cloak x-show="isExpanded" id="acc-single-{{$id}}" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
       <ul class="ps-1 py-1">
           {!! $slot !!}
       </ul>

    </div>
</li>
