<x-lareon::admin-entry-layout>
    @section('title', __(':title list',['title'=>__('permissions')]))
    @section('formRoute', route('admin.authorize.permissions.store'))
    @section('description', __('by permissions, user can access to different parts of the app'))
    @can('admin.permission.create')
        @section('form')
            <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique :title' ,['title'=>__('title')])" :required="true"/>
            <x-lareon::sections.text :title="__('description')" name="description" :placeholder="__('write a :title', ['title'=>__('description')])"/>
        @endsection
    @endcan
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title') , __('description') ,]">
                @foreach($permissions as $key=>$permission)
                    <tr>
                        <td class="p-3">{{$permissions->firstItem() + $key}}</td>
                        <td>{{$permission->title}}</td>
                        <td>{{$permission->description}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.edit :href="route('admin.authorize.permissions.edit' , $permission)" can="admin.permission.edit"/>
                                <x-lareon::link.delete :href="route('admin.authorize.permissions.destroy' , $permission)" can="admin.permission.delete"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-lareon::table>
            {{$permissions->appends($_GET)->links()}}

        </x-lareon::box>
    @endsection

</x-lareon::admin-entry-layout>
