<x-lareon::admin-layout>
    @section('title', __(':title list',['title'=>__('information')]))
    @section('description', __('in this window, the necessary data about the server and app is listed'))
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div class="lg:col-span-2">
            @foreach($data as $category=>$dta)
                <x-lareon::box class="mb-6">
                    <table
                        class="min-w-full border text-sm border-zinc-300 overflow-x-scroll divide-y divide-zinc-300 rounded-lg tableData">
                        <thead>
                        <tr>
                            <th colspan="2" class="text-center p-3 uppercase">{{$category}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dta as $key=>$value)
                            <tr>
                                @if(is_array($value))
                                    <td class="p-3">
                                        <table
                                            class="min-w-full border border-zinc-300 overflow-x-scroll divide-y divide-zinc-300 rounded-lg tableData">
                                            <thead>
                                            <tr>
                                                <th colspan="2" class="text-center p-3 uppercase">{{$key}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($value as $ky=>$val)
                                                <tr>
                                                    <th class="w-1/2 text-start p-3 uppercase">
                                                        {{$ky}}
                                                    </th>
                                                    <td class="w-1/2 text-start p-3">
                                                        {{$val}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                @elseif(is_string($value))
                                    <th class="w-1/2 text-start p-3 uppercase">
                                        {{$key}}
                                    </th>
                                    <td class="w-1/2 text-start p-3">
                                        {{$value}}
                                    </td>
                                @endif
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </x-lareon::box>
            @endforeach
        </div>

    </div>

</x-lareon::admin-layout>
