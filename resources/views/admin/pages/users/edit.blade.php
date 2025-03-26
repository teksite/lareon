<x-lareon::admin-editor-layout type="update"  :instance="$user">
    @section('title', __('edit the :title',['title'=>__('user'). " ($user->name)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('user') . " ($user->name)"]))

    @section('formRoute', route('admin.users.update', $user))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.users.index')" :title="__('all :title',['title'=>__('users')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.users.create')" :title="__('new :title',['title'=>__('user')])" color="create" can="admin.user.create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.trash :href="route('admin.users.destroy', $user)" can="admin.user.delete"/>
    @endsection
    @section('form')
       <div class="grid xl:grid-cols-2 gap-6">
           <div>
           <x-lareon::sections.text :value="old('name') ?? $user->name" :title="__('name')" name="name" :placeholder="__('write a :title for :item',['title'=>__('name') , 'item'=>__('user')])" :required="true"/>
           <x-lareon::sections.text :value="old('nick_name') ?? $user->nick_name ?? $user->name" :title="__('nickname')" name="nick_name" :placeholder="__('write a :title',['title'=>__('nickname')])" :required="false"/>
           <x-lareon::sections.text :value="old('phone') ?? $user->phone" :title="__('phone')" name="phone" :placeholder="__('write a :title',['title'=>__('phone')])" :required="true" type="phone" readonly disabled/>
           <x-lareon::sections.text :value="old('email') ?? $user->email" :title="__('email')" name="email" :placeholder="__('write a :title',['title'=>__('email')])" :required="true" type="email" readonly disabled/>
           @if($user->email_verified_at)
               <x-lareon::sections.text :value="dateAdapter($user->email_verified_at)" name="v" :title="__('email verified at')" readonly disabled/>
           @else
              <x-lareon::sections.checkbox value="1" :title="__('verifying email')" name="email_verified"/>
           @endif
           @if($user->phone_verified_at)
               <x-lareon::sections.text :value="dateAdapter($user->phone_verified_at)" name="v" :title="__('phone verified at')" readonly disabled/>
           @else
              <x-lareon::sections.checkbox value="1" :title="__('verifying phone')" name="phone_verified"/>
           @endif
           <x-lareon::sections.text :value="old('telegram_id') ?? $user->telegram_id" :title="__('telegram_id')" name="telegram_id" :placeholder="__('write a :title',['title'=>__('telegram id')])"/>
           <x-lareon::sections.password value="" :title="__('new :title' ,['title'=>__('password')])" name="password" :placeholder="__('leave it empty to not change')"/>
           </div>
           <!--//TODO: Create image avatar selection -->
           <img src="" alt="{{__('avatar') .' '.$user->name }}" width="250" height="250" >
       </div>
    @endsection
    @section('form.before.end')
        <x-lareon::box>
            <h2 class="mb-3">
                {{__('information')}}
            </h2>
            <div class="grid md:grid-cols-2 gap-6">
            @foreach(config('user-info.social',[]) as $key=>$condition)
                <div class="{{$condition['type'] == 'textarea' ? 'md:col-span-2' : ''}}">
                    <div class="flex items-center gap-3 mb-1">
                        <x-lareon::input.checkbox :value="1" id="meta.social.{{$key}}.active" name="meta[social][{{$key}}][active]" :checked="old('meta.social.'.$key.'.active' , $meta[$key]['active'] ?? 0)"/>
                        <x-lareon::input.label :title="__($key)" for="meta.social.{{$key}}.active" class="!mb-0"/>
                    </div>
                    <div>
                    @if($condition['type'] === 'textarea')
                        <x-lareon::input.textarea :title="__($key)" name="meta[social][{{$key}}][value]">{{old('meta.social.'.$key.'.value') ?? $meta[$key]['value'] ?? ''}}</x-lareon::input.textarea>
                    @else
                        <x-lareon::input.text type="{{$condition['type']}}" :value="old('meta.social.'.$key.'.value') ?? $meta[$key]['value'] ?? ''" :title="__($key)" name="meta[social][{{$key}}][value]"/>@endif
                    </div>
                </div>
            @endforeach
            </div>
        </x-lareon::box>

    @endsection
    @section('aside')
        <x-lareon::sections.permissions :instance="$user"/>
        <x-lareon::sections.roles :instance="$user"/>
    @endsection
</x-lareon::admin-editor-layout>
