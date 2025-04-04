<aside class=" fixed top-0 start-0 w-3/4 md:w-1/2 lg:w-1/3 xl:w-1/6 transition-all duration-100 -translate-x-full"
       :class="sidebar ? '{{is_rtl() ? 'translate-x-full' : '-translate-x-full'}} xl:translate-x-0' : 'translate-x-0 {{is_rtl() ? 'xl:translate-x-full' :'xl:-translate-x-full'}}' ">
    <div class="h-svh bg-slate-50 xl:bg-transparent shadow-sm xl:shadow-none border border-zinc-200 xl:border-none flex flex-col justify-between ps-3 py-3 rounded-lg">
        <div class=" overflow-auto flex flex-col gap-1">
            <div class="mb-6 flex items-center gap-1 min-h-fit h-fit">
                <div class="w-16">
                    <x-lareon::logo/>
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-1 capitalize">
                        LAREON
                    </h1>
                    <span class="text-zinc-600 font-black text-sm">
                        {{__('welcome :title' ,['title'=>'sina'])}}!
                     </span>
                </div>
            </div>
            <nav class=" h-full overflow-y-auto">
                <ul class="menu space-y-6">
                    @foreach(\Lareon\CMS\App\Services\MenuService::getAdminMenu() as $menu)
                        @isset($menu['children'])
                            <li class="">
                                <button class="flex items-center gap-1 justify-between w-full">
                                        <span class="flex items-center gap-1 justify-start">
                                              <i class="tkicon" data-icon="{{$menu['icon'] ?? 'paper-blank'}}"></i>
                                             {{__($menu['title'])}}
                                        </span>
                                    <i class="tkicon justify-self-end" data-icon="angle-right" size="8"></i>
                                </button>
                                <ul class="">
                                    @foreach($menu['children'] as $item)
                                        <li class="my-3">
                                            <a href="{{route($item['route'])}}" class="flex items-center gap-1 justify-start text-sm">
                                                <i class="tkicon" data-icon="circle" size="8"></i>
                                                {{__($item['title'])}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{route($menu['route'])}}" class="flex items-center gap-1 justify-start ">
                                    <i class="tkicon" data-icon="{{$menu['icon']}}"></i>
                                    {{__($menu['title'])}}
                                </a>
                            </li>
                        @endisset
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="px-3 pt-6 min-h-fit h-fit">
            <button class="logoutBtn flex w-full items-center justify-between min-h-fit text-red-600">
                <i class='tkicon stroke-red-600 stroke-2' data-icon='turn-off'></i>
                <span>
                    {{__('logout')}}
                </span>
            </button>
        </div>
    </div>
</aside>
