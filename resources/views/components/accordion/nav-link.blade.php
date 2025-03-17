@props(['title', 'href', 'icon_size'=>12,  'is_active'=>false])
<li x-data="{ isExpanded: false }" class="py-1">
    <a href="{{$href}}" class="{{$is_active ? 'font-bold' :''}} flex items-center justify-start gap-3 text-sm" title="{{__('visit :title', ['title'=>$title])}}">
        <i class="tkicon {{$is_active ? 'active' : 'stroke-blue-600'}}" data-icon="circle"  size="{{$icon_size}}"></i>
        {{$title}}
    </a>
</li>
