<div class="p-0.5 mb-6 flex items-center justify-between">
    <div class="min-w-fit">
        <a href="/" class="flex items-center gap-1 btn-stroke bg-slate-50">
            <i class="tkicon" data-icon="gage" ></i>
           <span>
                {{__('dashboard')}}
           </span>
        </a>
    </div>
    <hr class="border-dotted border-gray-300 w-full">
    <div class="min-w-fit flex justify-end items-center gap-6 btn-stroke bg-slate-50">
        <a href="{{route('admin.setlang')}}">
            Fa\En
        </a>
        <a href="/">
            <i class="tkicon" data-icon="world"></i>
        </a>
        @if(\Illuminate\Support\Facades\Route::has('panel.dashboard'))
            <a href="{{route('panel.dashboard')}}">
                <i class="tkicon" data-icon="user" ></i>
            </a>
        @endif
        <button class="hover:cursor-pointer" type="button" role="switch" @click="togglesSidebar()">
            <i class="tkicon" data-icon="bar-3" ></i>
        </button>
    </div>
</div>
