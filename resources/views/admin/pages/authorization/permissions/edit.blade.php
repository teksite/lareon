<x-lareon::admin-editor-layout type="update"  :instance="$permission">
    @section('title', __('edit the :title',['title'=>__('permission'). " ($permission->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('permission') . " ($permission->title)"]))
    @section('formRoute', route('admin.authorize.permissions.update', $permission))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.authorize.permissions.index')" :title="__('all :title',['title'=>__('permissions')])" color="index"/>
    @endsection
    @section('header.end')
        @parent
        <x-lareon::link.delete :href="route('admin.authorize.permissions.destroy', $permission)" can="admin.permission.delete"/>
    @endsection
    @section('form')
        <x-lareon::box>
            <x-lareon::sections.text :value="$permission->title" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
            <x-lareon::sections.text :value="$permission->description" :title="__('description')" name="description" :placeholder="__('write a :title' ,['title'=>__('description')])"/>
        </x-lareon::box>
    @endsection
</x-lareon::admin-editor-layout>
