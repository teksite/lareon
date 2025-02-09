<aside class="p-3 fixed top-0 start-0 w-3/4 md:w-1/2 lg:w-1/3 xl:w-1/6 transition-all duration-100 -translate-x-full"
       :class="sidebar ? '-translate-x-full xl:translate-x-0' : 'translate-x-0 xl:-translate-x-full' ">
    <div class="min-h-dvh bg-white xl:bg-transparent shadow-sm xl:shadow-none border border-zinc-200 xl:border-none flex flex-col justify-between p-3 rounded">
       <div class="min-h-full">
           <div class="mb-6 flex items-center gap-1">
              <div class="w-16">
                  <x-lareon::logo />
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
           <nav class="">
               <ul class="space-y-6">
                   <x-lareon::accordion.link :title="__('dashboard')" :href="route('admin.dashboard')" icon="gage" icon_size="24" :is_active="Route::currentRouteName() === 'admin.dashboard'"/>
                   <x-lareon::accordion.nav :title="__('post')" icon="paper-blank" :is_active="request()->routeIs(['admin.dashboard'])">
                       <x-lareon::accordion.nav-link :title="__('erwer')" :href="route('admin.dashboard')" :is_active="request()->routeIs(['admin.dashboard'])"/>
                   </x-lareon::accordion.nav>

                   <x-lareon::accordion.nav :title="__('appearance')" icon="columns-three" :is_active="request()->routeIs(['admin.appearance.*'])">
                       <x-lareon::accordion.nav-link :title="__('icons')" :href="route('admin.appearance.icons.index')" :is_active="request()->routeIs(['admin.appearance.icons.index'])"/>
                   </x-lareon::accordion.nav>
               </ul>
           </nav>
       </div>
        <div class="pb-6">
            <button class="logoutBtn flex w-full items-center justify-between min-h-fit text-red-600">
                <i class='tkicon stroke-red-600 stroke-2' data-icon='turn-off'></i>
                <span>
                    {{__('logout')}}
                </span>
            </button>
        </div>
    </div>

</aside>
