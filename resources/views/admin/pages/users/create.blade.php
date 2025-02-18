<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('user')]))
    @section('formRoute', route('admin.users.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.users.index')" :title="__('all :title',['title'=>__('users')])"/>
    @endsection
    @section('form')
        <x-lareon::sections.text :title="__('name')" name="name" :placeholder="__('enter a :title' ,['title'=>__('name')])" :required="true"/>
        <x-lareon::sections.text type="email" :title="__('email')" name="email" :placeholder="__('enter a unique :title' ,['title'=>__('email')])" :required="true"/>
        <x-lareon::sections.text type="phone" :title="__('phone')" name="phone" :placeholder="__('enter a unique :title' ,['title'=>__('phone')])" :required="true"/>
        <x-lareon::sections.text type="password" :title="__('password')" name="password" :placeholder="__('enter a :title' ,['title'=>__('password')])" :required="true"/>
        <x-lareon::sections.text type="password" :title="__('password confirmation')" name="password_confirmation" :placeholder="__('re-enter the password')" :required="true"/>
    @endsection
    @section('aside')
        <x-lareon::sections.permissions />
    @endsection
</x-lareon::admin-editor-layout>
