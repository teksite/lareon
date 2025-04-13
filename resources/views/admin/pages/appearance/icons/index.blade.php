<x-lareon::admin-layout>
    @section('title', __(':title list',['title'=>__('icons')]))
    @section('description', __('by these svg icons, you can have light and flexible icon'))
    <dev class="mb-3 bg-zinc-900 rounded p-3 text-slate-50 block w-full" dir="ltr" style="box-shadow:-5px 0 0 0 green">
                <pre>
<code class="font-bold">&lt;<span>i</span> class='tkicon stroke-black fill-none' size='24' data-icon='example'&gt;&lt;<span>/i</span>&gt;</code>
</pre>
    </dev>
    <dev class="mb-3 bg-zinc-900 rounded p-3 text-slate-50 block w-full" dir="ltr" style="box-shadow:-5px 0 0 0 blue">
        <pre>
<code class="font-bold">&lt;<span>style</span>&gt;
    .tkicon.example:nth-child(1) {
      fill:none;
      stroke: <span>#696969</span>
    }
    .tkicon.example:nth-child(2) {
        fill:none;
        stroke: #696969
    }
&lt;<span>style</span>&gt;</code>
</pre>
    </dev>
    <ul id="iconList" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-6" ></ul>

</x-lareon::admin-layout>
