@props(['href' , 'can'=>null])
@can($can)
    @php($random='id_form-'.rand(1000,9999))
    <form method="POST" action="{{$href}}" id="{{$random}}" class="deltfrmItms">
        @csrf
        @method('DELETE')
        <button class="hover:bg-zinc-300 hover:cursor-pointer p-1 rounded-full">
            <i class="tkicon fill-none stroke-red-600 " data-icon="trash" size="18" stroke-width="2"></i>
        </button>
    </form>
@endcan
