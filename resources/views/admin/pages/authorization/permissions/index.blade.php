<x-lareon::admin-credix-layout>
    @section('title', __(':title list',['title'=>__('permissions')]))
    @section('formRoute', route('admin.authorize.permissions.store'))

    @section('header.end')
        @parent
    @endsection
    @section('form')
        <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique :title' ,['title'=>__('title')])"
                                 :required="true"/>
        <x-lareon::sections.text :title="__('description')" name="description" :placeholder="__('enter a :title', ['title'=>__('description')])"/>
    @endsection
    @section('index')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title') , __('description') ,]">
                @foreach($permissions as $key=>$permission)
                    <tr>
                        <td class="p-3">{{$permissions->firstItem() + $key}}</td>
                        <td>{{$permission->title}}</td>
                        <td>{{$permission->description}}</td>
                        <td>
                            <div class="action">
                                @can('admin.permission.edit')
                                    <x-lareon::link.edit :href="route('admin.authorize.permissions.edit' , $permission)"/>
                                @endcan
                                @can('admin.permission.delete')
                                    <x-lareon::link.trash :href="route('admin.authorize.permissions.destroy' , $permission)"/>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-lareon::table>
            {{$permissions->appends($_GET)->links()}}

        </x-lareon::box>
    @endsection

</x-lareon::admin-credix-layout>
