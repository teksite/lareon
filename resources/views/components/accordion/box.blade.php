@props(['title'=>null, 'icon'=>null ,'open'=>false ,'accordion'=>true])
@php($id='acc-box-'.rand(1000,9999))
@if($accordion)
    <div x-data="{ isExpanded: @js($open) }" >
        <div class="x-box !p-0">
            <button id="{{$id}}" role="tab" type="button" class="flex w-full items-center justify-between gap-3 text-sm font-semibold p-3" aria-controls="{{$id}}" x-on:click="isExpanded = ! isExpanded" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
                {{$title}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            <div x-cloak x-collapse x-show="isExpanded" id="{{$id}}" role="region" aria-labelledby="controlsAccordionItemOne" class=" p-3">
                <hr class="border-slate-200 mb-3">
                {!! $slot ?? '' !!}
            </div>
        </div>
    </div>
@else
    <div class="x-box">
      @if($title)
            <h4>
                {{__($title)}}
            </h4>
      @endif
        <div id="{{$id}}">
            {!! $slot ?? '' !!}
        </div>
    </div>

@endif
