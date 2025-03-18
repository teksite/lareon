<header
    class=" mb-6 w-full rounded-lg overflow-hidden  bg-[url(/public/uploads/tk-admin/1738641169.webp)] bg-cover bg-no-repeat">
    <div class="bg-zinc-900/50 w-full h-full p-3 min-h-64 flex items-center">
       <div>
           <h2 class="mb-3">
               @yield('title' ,  __('dashboard'))
           </h2>
           <p class="text-zinc-600 font-semibold">
               @yield('description' , '')
           </p>
       </div>
    </div>
    @if(View::hasSection('header.start') || View::hasSection('header.end') )
        <div class="x-box flex flex-col sm:flex-row items-center justify-between gap-6 -mt-12 w-11/12 mx-auto ">
            <div class="flex items-center justify-start gap-3">
                @yield('header.start')
            </div>
            <div class="flex items-center justify-end gap-3">
                @yield('header.end')
            </div>
        </div>
    @endif

</header>
