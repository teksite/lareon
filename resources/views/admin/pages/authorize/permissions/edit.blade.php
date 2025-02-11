<x-lareon::admin-editor-layout type="update"  :instance="$permission">
    @section('title', __('edit permissions'))
    @section('formRoute', route('admin.authorize.permissions.update', $permission))
    @section('form')
        <x-lareon::sections.text :value="$permission->title" :title="__('title')" name="title" :placeholder="__('enter a unique title')" :required="true"/>
        <x-lareon::sections.text :value="$permission->description" :title="__('description')" name="description" :placeholder="__('write a :title' ,['title'=>__('description')])"/>
    @endsection

</x-lareon::admin-editor-layout>
