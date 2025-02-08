<x-lareon::admin-credix-layout>
@section('title', __('permissions'))
@section('formRoute', route('admin.authorize.permissions.store'))
@section('form')
    <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique title')" :required="true" />
    <x-lareon::sections.text :title="__('description')" name="description" :placeholder="__('enter a description')" />
@endsection
@section('index')
    <x-lareon::box>
        <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique title')" :required="true" />
        <x-lareon::sections.text :title="__('description')" name="description" :placeholder="__('enter a description')" />
    </x-lareon::box>
@endsection

</x-lareon::admin-credix-layout>
