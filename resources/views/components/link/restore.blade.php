@props(['href' , 'can'=>null])
@can($can)
    @php($random='id_form-'.rand(1000,9999))
    <form method="POST" action="{{$href}}" id="{{$random}}">
        @csrf
        @method('patch')
        <button class="hover:bg-zinc-300 hover:cursor-pointer p-1 rounded-full">
            <i class="tkicon fill-none stroke-blue-600 " data-icon="recycle" size="18" stroke-width="2"></i>
        </button>
    </form>
@endcan
