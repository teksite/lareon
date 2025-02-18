<x-lareon::admin-index-layout>
    @section('title', __(':title list',['title'=>__('roles')]))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.authorize.roles.create')"/>
    @endsection
    @section('header.end')
        @parent
    @endsection
    @section('index')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title'),'hierarchy'=>__('hierarchy') , __('description') ,]">
                @foreach($roles as $key=>$role)
                    <tr>
                        <td class="p-3">{{$roles->firstItem() + $key}}</td>
                        <td>{{$role->title}}</td>
                        <td>{{$role->hierarchy}}</td>
                        <td>{{$role->description}}</td>
                        <td>
                            <div class="action">
                                @can('admin.role.edit')
                                    <x-lareon::link.edit :href="route('admin.authorize.roles.edit' , $role)"/>
                                @endcan
                                @can('admin.role.delete')
                                    <x-lareon::link.trash :href="route('admin.authorize.roles.destroy' , $role)"/>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-lareon::table>
            {{$roles->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-index-layout>
