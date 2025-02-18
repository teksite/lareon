<x-lareon::admin-editor-layout type="update"  :instance="$permission">
    @section('title', __('edit the :title',['title'=>__('permission')]))
    @section('formRoute', route('admin.authorize.permissions.update', $permission))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.authorize.permissions.index')" :title="__('all :title',['title'=>__('permissions')])"/>
    @endsection
    @section('header.end')
        @parent
        @can('admin.permission,delete')
            <x-lareon::link.trash :href="route('admin.authorize.permissions.destroy', $permission)"/>
        @endcan
    @endsection
    @section('form')
        <x-lareon::sections.text :value="$permission->title" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.text :value="$permission->description" :title="__('description')" name="description" :placeholder="__('write a :title' ,['title'=>__('description')])"/>
    @endsection

</x-lareon::admin-editor-layout>
