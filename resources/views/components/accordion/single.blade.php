@props(['title', 'icon'=>null])
@php($id=rand(1000,9999))
<div x-data="{ isExpanded: false }">
    <button id="{{$id}}" role="tab" type="button" class="flex w-full items-center justify-between gap-3 bg-neutral-50 p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-hidden dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75" aria-controls="acc-single-{{$id}}" x-on:click="isExpanded = ! isExpanded" x-bind:class="isExpanded ? 'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold'  : 'text-onSurface dark:text-onSurfaceDark font-medium'" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
        What browsers are supported?
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
    </button>
    <div x-cloak x-show="isExpanded" id="acc-single-{{$id}}" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
        {!! $slot ?? '' !!}
    </div>
</div>
