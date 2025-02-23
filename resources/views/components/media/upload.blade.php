<form method="POST" action="{{route('admin.appearance.media.upload')}}" enctype="multipart/form-data">
    @csrf
    <div class="flex items-center justify-center border border-zinc-600 rounded-lg p-6 mb-3">
        <input type="file" name="media">
    </div>
    <x-lareon::button.solid>
        {{__('upload')}}
    </x-lareon::button.solid>
</form>
