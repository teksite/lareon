<x-lareon::admin-editor-layout type="delete">
    @php($logFile=request()->input('log' , 'laravel.log'))
    @section('title', __('logs and errors'))
    @section('formRoute', route('admin.settings.logs.delete' , ['log'=>$logFile]))
    @section('header.start')
        <form method="GET">
            <div class="flex items-center gap-3">
                <x-lareon::input.label :title="__('files')" for="files"/>
                <x-lareon::input.select name="log" id="files" onchange="this.form.submit()" aria-label="{{__('logs')}}">
                    @foreach($files as $file)
                        <option value="{{$file}}" {{$logFile == $file ? 'selected' :'' }}>{{$file}}</option>
                    @endforeach
                </x-lareon::input.select>
            </div>
            <x-lareon::input.error :messages="$errors->get('log')"/>

        </form>
    @endsection

    @section('form')
      <div x-data="{wrap : false}">
          <div class="inline-flex gap-1 items-center" >
              <x-lareon::input.checkbox id="wrap"  x-model="wrap" @click="wrap = !wrap" />
              <x-lareon::input.label title="wrap?" for="wrap" />
          </div>
          <hr class="my-3">
          <pre class="w-full overflow-x-auto bg-zinc-800 text-gray-200 p-3 rounded" :class="{'text-wrap': wrap}"><code>{{$content}}</code></pre>
      </div>
    @endsection
</x-lareon::admin-editor-layout>
