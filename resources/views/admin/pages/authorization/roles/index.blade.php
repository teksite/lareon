<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('roles')]))
    @section('description', __('by roles, user can be categorized and have access to different parts of the app'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.authorize.roles.create')" :title="__('create a new one')" color="create" can="admin.role.create"/>
    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title'),'hierarchy'=>__('hierarchy') , __('description') ,]">
                @if(count($roles))
                @foreach($roles as $key=>$role)
                    <tr>
                        <td class="p-3">{{$roles->firstItem() + $key}}</td>
                        <td>{{$role->title}}</td>
                        <td>{{$role->hierarchy}}</td>
                        <td>{{$role->description}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.edit :href="route('admin.authorize.roles.edit' , $role)" can="admin.role.edit"/>
                                <x-lareon::link.trash :href="route('admin.authorize.roles.destroy' , $role)" can="admin.role.delete"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <p class="text-center">
                                {{__('no item has been found')}}.
                            </p>
                        </td>
                    </tr>
                @endif
            </x-lareon::table>
            {{$roles->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
