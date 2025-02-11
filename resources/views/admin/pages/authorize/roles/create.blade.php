<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('role')]))
    @section('formRoute', route('admin.authorize.roles.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.authorize.roles.index')" :title="__('all :title',['title'=>__('roles')])"/>
    @endsection
    @section('form')
        <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique title')" :required="true"/>
        <x-lareon::sections.text :title="__('description')" name="description" :placeholder="__('write a :title' ,['title'=>__('description')])" :required="false"/>
    @endsection
    @section('aside')
        <x-lareon::sections.permissions />
    @endsection
</x-lareon::admin-editor-layout>
