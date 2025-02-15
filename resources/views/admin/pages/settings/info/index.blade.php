<x-lareon::admin-layout>
    @section('title', __('information'))
    <div class="grid gap-7 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <section class="mb-6">
                <x-lareon::box>
                    <x-lareon::table :headers="['title','version']">
                        <tr>
                            <td class="px-3 py-1">Lareon</td>
                            <td class="px-3 py-1">2.0.1</td>
                        </tr>
                    </x-lareon::table>
                </x-lareon::box>
            </section>
            <section class="mb-6">
                <x-lareon::box>
                    <x-lareon::table :headers="['title','version']">
                        <tr>
                            <td class="px-3 py-1">{{'server software'}}</td>
                            <td class="px-3 py-1">{{$_SERVER['SERVER_SOFTWARE']}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">{{'time zone'}}</td>
                            <td class="px-3 py-1">{{date_default_timezone_get()}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">{{'php version'}}</td>
                            <td class="px-3 py-1">{{phpversion()}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">{{'database driver'}}</td>
                            <td class="px-3 py-1">{{config('database.default')}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">{{'cache driver'}}</td>
                            <td class="px-3 py-1">{{config('cache.default')}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">{{'session driver'}}</td>
                            <td class="px-3 py-1">{{config('session.driver')}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">{{'queue driver'}}</td>
                            <td class="px-3 py-1">{{config('queue.default')}}</td>
                        </tr>


                    </x-lareon::table>
                </x-lareon::box>
            </section>
            <section class="mb-6">
                <x-lareon::box>
                    <x-lareon::table :headers="['title','version']" :linkable="false">
                        <tr>
                            <td class="px-3 py-1">max upload</td>
                            <td class="px-3 py-1">{{(int)(ini_get('upload_max_filesize'))}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">max post</td>
                            <td class="px-3 py-1">{{(int)(ini_get('post_max_size'))}}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1">memory limit</td>
                            <td class="px-3 py-1">{{(int)(ini_get('memory_limit'))}}</td>
                        </tr>
                        {{--                <tr>--}}
                        {{--                    <td class="px-3 py-1">memory limit</td>--}}
                        {{--                    <td class="px-3 py-1">{{(int)(disk_free_space(storage_path()))}}</td>--}}
                        {{--                </tr>--}}

                    </x-lareon::table>
                </x-lareon::box>

            </section>
            <section class="mb-6">
                <x-lareon::box>
                    <h2 class="text-center">
                        {{__('extensions')}}
                    </h2>
                    <x-lareon::table :headers="['title','version']" :linkable="false">
                        @foreach (get_loaded_extensions() as $ext)
                            <tr>
                                <td class="p-3">{{$ext}}</td>
                                <td class="p-3">{{phpversion($ext)}}</td>
                            </tr>
                        @endforeach


                    </x-lareon::table>
                </x-lareon::box>
            </section>
        </div>
        <div>
            <section class="mb-6" id="usageSection">
                <x-lareon::box>
                    <h2 class="text-center">
                        {{__('usages')}}
                    </h2>
                    <x-lareon::table :headers="['title','version']" :linkable="false">
                        <tr>
                            <td class="p-3">CPU</td>
                            <td class="p-3" id="cpuUsage">{{$usages['cpu']}}</td>
                        </tr>
                        <tr>
                            <td class="p-3">MEMORY</td>
                            <td class="p-3" id="memoryUsage">{{$usages['memory']}}</td>
                        </tr>

                        <tr>
                            <td class="p-3">DISK</td>
                            <td class="p-3" id="disUsage">{{$usages['disk']}}</td>
                        </tr>

                    </x-lareon::table>
                </x-lareon::box>
            </section>
        </div>
    </div>
</x-lareon::admin-layout>
