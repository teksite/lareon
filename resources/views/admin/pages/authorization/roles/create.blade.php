<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('role')]))
    @section('description', __('in this window you can creat a new :title',['title'=>__('role')]))
    @section('formRoute', route('admin.authorize.roles.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.authorize.roles.index')" :title="__('all :title',['title'=>__('roles')])" color="teal"/>
    @endsection
    @section('form')
        <x-lareon::sections.text :value="old('title')" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.text :value="old('description')" :title="__('description')" name="description" :placeholder="__('write a :title' ,['title'=>__('description')])" :required="false"/>
        <x-lareon::sections.text :value="old('hierarchy') ?? \Lareon\CMS\App\Models\User::hierarchy('min') + 1" type="number" :title="__('hierarchy')" name="hierarchy" :placeholder="__('choose a :title' ,['title'=>__('hierarchy')])" :required="true"/>
    @endsection
    @section('aside')
        <x-lareon::sections.permissions />
    @endsection
</x-lareon::admin-editor-layout>
