@props(['title', 'href', 'icon'=>'circle', 'icon_size'=>12,  'is_active'=>false])
<li x-data="{ isExpanded: false }">
    <a href="{{$href}}" class="text-sm {{$is_active ? 'font-bold' :''}} flex items-center justify-start gap-3" title="{{__('visit :title', ['title'=>$title])}}">
        <i class="tkicon {{$is_active ? 'active' : ''}}" data-icon="{{$icon}}"  size="{{$icon_size}}"></i>
        {{$title}}
    </a>
</li>
