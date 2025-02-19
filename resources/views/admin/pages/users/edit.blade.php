<x-lareon::admin-editor-layout type="update" :instance="$user" xmlns:x-lareon="http://www.w3.org/1999/html">
    @section('title', __('edit the :title',['title'=>__('user')]))
    @section('formRoute', route('admin.users.update', $user))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.users.index')"
                                    :title="__('all :title',['title'=>__('users')])"/>
    @endsection
    @section('header.end')
        @parent
        <x-lareon::link.trash :href="route('admin.users.destroy', $user)"/>
    @endsection
    @section('form')
        <div class="grid xl:grid-cols-2 2xl:grid-cols-4 gap-6 items-center">
            <section class="xl:col-span-2">
                <x-lareon::sections.text :title="__('name')" name="name" :placeholder="__('enter a :title' ,['title'=>__('name')])" :required="true" :value="old('name') ?? $user->name"/>
                @if(auth()->user()->hasRole(['admin','administryuator']))
                    <x-lareon::sections.text :title="__('email')" name="email" :placeholder="__('enter a :title' ,['title'=>__('email')])" :required="true" :value="old('email') ?? $user->email"/>
                    <x-lareon::sections.text :title="__('phone')" name="phone" :placeholder="__('enter a :title' ,['title'=>__('phone')])" :required="true" :value="old('phone') ?? $user->phone"/>
                @else
                    <x-lareon::input.label :title="__('email')"/>
                    <p class="input text-zinc-400 mb-3" class="cursor-default">{{$user->email}}</p>
                    <x-lareon::input.label :title="__('phone')"/>
                    <p class="input text-zinc-400 mb-3" class="cursor-default">{{$user->phone}}</p>
                @endif
                <x-lareon::input.label :title="__('slug')"/>
                <p class="input text-zinc-400 mb-3" class="cursor-default">{{$user->slug}}</p>
                <x-lareon::sections.text type="password" :title="__('password')" name="password" :placeholder="__('enter a :title' ,['title'=>__('password')])"/>
            </section>
            <section class="xl:col-span-2">
                <img src="{{$user->featured_image}}" alt="{{$user->name}}" class="mx-auto" width="300" height="300" fetchpriority="low" decoding="async" loading="lazy">
            </section>
        </div>
    @endsection
    @section('beforeEndForm')
           <x-lareon::accordion.single :title="__('extra :title',['title'=>__('info')])" :open="false">
               <p class="mb-6 font-bold">{{__('check each item to show in your profile page')}}.</p>
               <p class="mb-6 text-red-900 font-bold">{{__('social id, economic code and registration code are not shown at all')}}.</p>
               <div class="">
                   @foreach(config('cms.cms.users.extra.public',[]) as $col=>$title)
                       <div class="mb-6">
                           <div class="flex items-center gap-1">
                               <x-lareon::input.checkbox id="{{$col}}_activation" name="meta[info][{{$col}}][status]" value="1" :checked="isset($meta[$col]['status'])"/>
                               <x-lareon::input.label for="{{$col}}_activation" :title="__($title)"/>
                           </div>
                           <x-lareon::input.text id="{{$col}}_value" name="meta[info][{{$col}}][value]" :value="old('meta.info.'.$col.'.value') ?? $meta[$col]['value'] ?? ''"/>
                       </div>
                   @endforeach
                   <hr class="my-6">
                   <section class="grid md:grid-cols-2 gap-6 mb-6">
                       @foreach(config('cms.cms.users.extra.legal',[]) as $col=>$title)
                           <div class="mb-3">
                               <div class="flex items-center gap-1">
                                   <x-lareon::input.checkbox id="{{$col}}_activation" name="meta[info][{{$col}}][status]" value="1" :checked="isset($meta[$col]['status'])"/>
                                   <x-lareon::input.label for="{{$col}}_activation" :title="__($title)"/>
                               </div>
                               <x-lareon::input.text id="{{$col}}_value" name="meta[info][{{$col}}][value]" :value="old('meta.info.'.$col.'.value') ?? $meta[$col]['value'] ?? ''"/>
                           </div>
                       @endforeach
                   </section>
                   <hr class="my-6">
                   <section class="grid md:grid-cols-2 gap-6 mb-6">
                       @foreach(config('cms.cms.users.extra.social',[]) as $col=>$title)
                           <div class="mb-3">
                               <div class="flex items-center gap-1">
                                   <x-lareon::input.checkbox id="{{$col}}_activation" name="meta[info][{{$col}}][status]" value="1" :checked="isset($meta[$col]['status'])"/>
                                   <x-lareon::input.label for="{{$col}}_activation" :title="__($title)"/>
                               </div>
                               <x-lareon::input.text id="{{$col}}_value" name="meta[info][{{$col}}][value]" :value="old('meta.info.'.$col.'.value') ?? $meta[$col]['value'] ?? ''"/>
                           </div>
                       @endforeach
                   </section>
               </div>
           </x-lareon::accordion.single>
    @endsection
    @section('aside')

    @endsection

</x-lareon::admin-editor-layout>
