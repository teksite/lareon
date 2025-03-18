@props(['instance'])
<x-lareon::box >
    <h3>
        <x-lareon::input.label :title="__('release information')" />
    </h3>
    <section class="p-3 rounded border border-dotted border-zinc-600">
        <div class="flex items-center gap-3 justify-between text-xs">
        <span class="font-bold text-green-600 min-w-fit">
            {{__('created at')}}
        </span>
            <hr class="border-dotted w-full">
            <span class="min-w-fit">
            {{dateAdapter($instance->created_at) ?? '-'}}
        </span>
        </div>
        <div class="flex items-center gap-3 justify-between text-xs ">
        <span class="font-bold text-blue-600 min-w-fit">
            {{__('updated at')}}
        </span>
            <hr class="border-dotted w-full">
            <span class="min-w-fit">
            {{dateAdapter($instance->updated_at) ?? '-'}}
        </span>
        </div>
        @if($instance->publish_at)
            <div class="flex items-center gap-3 justify-between text-xs">
            <span class="font-bold">
                {{__('publish at')}}
            </span>
                <hr class="border-dotted w-full">
                <span class="min-w-fit">
                {{dateAdapter($instance->publish_at) ?? '-'}}
            </span>
            </div>
        @endif
        @if($instance->read_at)
            <div class="flex items-center gap-3 justify-between text-xs">
            <span class="font-bold text-purple-600">
                {{__('read at')}}
            </span>
                <hr class="border-dotted w-full">
                <span class="min-w-fit">
                {{dateAdapter($instance->read_at) ?? '*-'}}
            </span>
            </div>
        @endif
    </section>
</x-lareon::box>
