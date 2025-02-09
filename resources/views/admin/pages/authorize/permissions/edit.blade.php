<x-lareon::admin-editor-layout type="update" >
    @section('title', __('edit permissions'))
    @section('formRoute', route('admin.authorize.permissions.update', $permission))
    @section('form')
        <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique title')" :required="true"/>
        <x-lareon::sections.text :title="__('description')" name="description" :placeholder="__('enter a description')"/>
    @endsection

</x-lareon::admin-editor-layout>
