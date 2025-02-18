<x-lareon::admin-index-layout>
    @section('title', __(':title list',['title'=>__('users')]))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.users.create')"/>
    @endsection
    @section('header.end')
        @parent
    @endsection
    @section('index')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','featured_image','name'=>__('name'),'email'=>__('email') ,'phone'=>__('phone') ,'role'=>__('roles') ,]">
                @foreach($users as $key=>$user)
                    <tr>
                        <td class="p-3">{{$users->firstItem() + $key}}</td>
                        <td>
                            <img src="{{$user->featured_image}}" alt="{{$user->name}}" class="rounded-full w-6 h-6" width="75" height="75" fetchpriority="low" decoding="async" loading="lazy">
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->roles->pluck('title')->implode(',')}}</td>
                        <td>
                            <div class="action">
                                @can('admin.user.edit')
                                    <x-lareon::link.edit :href="route('admin.users.edit' , $user)"/>
                                @endcan
                                @can('admin.user.delete')
                                    <x-lareon::link.trash :href="route('admin.users.destroy' , $user)"/>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-lareon::table>
            {{$users->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-index-layout>
