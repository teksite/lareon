@props(['files'=>[]])
<div class="mx-auto flex items-start gap-6 mt-6" xmlns:x-lareon="http://www.w3.org/1999/html">
    <div class="sticky top-6">
        <ul class="min-w-1/4 min-w-fit space-y-3">
            <li class="mb-3">
                <a href="?type=image"
                   class="bg-white block shadow w-full px-3 py-1 rounded {{request()->type=='image' ? 'text-blue-600' :''}}">
                    {{__('images')}}
                </a>
            </li>
            <li class="mb-3">
                <a href="?type=video"
                   class="bg-white block shadow w-full px-3 py-1 rounded {{request()->type=='video' ? 'text-blue-600' :''}}">
                    {{__('videos')}}
                </a>
            </li>
            <li class="mb-3">
                <a href="?type=audio"
                   class="bg-white block shadow w-full px-3 py-1 rounded {{request()->type=='audio' ? 'text-blue-600' :''}}">
                    {{__('audios')}}
                </a>
            </li>
            <li class="mb-3">
                <a href="?type=text"
                   class="bg-white block shadow w-full px-3 py-1 rounded {{request()->type=='text' ? 'text-blue-600' :''}}">
                    {{__('texts')}}
                </a>
            </li>
            <li class="mb-3">
                <a href="?type=application"
                   class="bg-white block shadow w-full px-3 py-1 rounded {{request()->type=='application' ? 'text-blue-600' :''}}">
                    {{__('application')}}
                </a>
            </li>
        </ul>
    </div>
    <div class="p-3 border-s border-slate-200 w-full" id="galleryList">
        <ul class="flex items-start gap-3 flex-wrap" id="galleryListEl">
            @foreach($files as $file)
                <li class="border border-zinc-300 rounded aspect-square min-w-fit w-fit">
                    @if( str_starts_with($file->mime_type, 'image'))
                        <img class="itemGallery" src="{{$file->url}}" data-id="{{$file->id}}"
                             data-name="{{$file->name}}" data-file_name="{{$file->file_name}}"
                             data-user="{{$file->user_id}}" data-path="{{$file->path}}" width="200" height="auto"
                             alt="{{$file->file_name}}" fetchpriority="low" decoding="async" loading="lazy">
                    @elseif(str_starts_with($file->mime_type, 'video'))
                        <video class="itemGallery" src="{{$file->url}} data-id={{$file->id}}"
                               data-name="{{$file->name}}" data-file_name="{{$file->file_name}}"
                               data-user="{{$file->user_id}}" data-path="{{$file->path}}" controls></video>
                    @elseif(str_starts_with($file->mime_type, 'audio'))
                        <audio class="itemGallery" src="{{$file->url}}" data-id="{{$file->id}}"
                               data-name="{{$file->name}}" data-file_name="{{$file->file_name}}"
                               data-user="{{$file->user_id}}" data-path="{{$file->path}}" controls></audio>
                    @else
                        <a href="{{$file->url}}" data-id="{{$file->id}}" data-name="{{$file->name}}"
                           data-file_name="{{$file->file_name}}" data-user="{{$file->user_id}}" data-target="_blank">
                            <img src="" alt="" width="200" height="200" fetchpriority="low" decoding="async" loading="lazy">
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="flex items-center justify-center p-3 mt-6">
            <x-lareon::button.solid id="loadMoreGallery">
                {{__('load more')}}
            </x-lareon::button.solid>
        </div>
    </div>


</div>

<div class="fixed bg-zinc-800/75 inset-0 w-full h-full z-10 flex items-center justify-center select-none"
     id="modalItemGallery" style="display: none">
    <div class="w-11/12 h-full relative overflow mx-auto my-12">
        <div
            class="m-auto grid md:grid-cols-2 lg:grid-cols-3 bg-white p-6 rounded-lg gap-3 max-[90dvh] h-[90dvh] overflow-y-auto"
            id="modalItemBox">
            <div class="col-span-1 space-y-3">
                <label for="itemName" class="font-bold mb-1 text-sm">{{__('name')}}</label>
                <input readonly dir="ltr" id="itemName" class="input text-nowrap overflow-clip">

                <label for="itemPath" class="font-bold mb-1 text-sm">{{__('path')}}</label>
                <input readonly dir="ltr" id="itemPath" class="input text-nowrap overflow-clip">

                <label for="itemUser" class="font-bold mb-1 text-sm">{{__('user')}}</label>
                <input readonly dir="ltr" id="itemUser" class="input text-nowrap overflow-clip">

                <label for="fileName" class="font-bold mb-1 text-sm">{{__('file name')}}</label>
                <input readonly dir="ltr" id="fileName" class="input text-nowrap overflow-clip">

                <label for="fileUrl" class="font-bold mb-1 text-sm">{{__('url')}}</label>
                <input readonly dir="ltr" id="fileUrl" class="input text-nowrap overflow-clip">

                <form action="{{route('admin.appearance.media.destroy')}}" method="POST">
                    @csrf @method('DELETE')
                    <input readonly dir="ltr" class="h-full" type="hidden" name="media" id="mediaIdToDelete">
                    <x-lareon::button.solid color="red">{{__('delete')}}</x-lareon::button.solid>
                </form>
            </div>
            <div id="modalPrev" class="lg:col-span-2"></div>
            <button id="closeGalleyModal" type="button" role="button"
                    class="absolute z-20 top-1  end-3 text-red-600 font-bold shadow p-1 bg-white rounded">X
            </button>
        </div>
    </div>
</div>
@push('footerScripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("modalItemGallery");
            if (!modal) return;

            const closeBtn = modal.querySelector("#closeGalleyModal");
            const modalPrev = modal.querySelector("#modalPrev");
            const modalBox = modal.querySelector("#modalItemBox");
            const modalUser = modal.querySelector("#itemUser");
            const modalName = modal.querySelector("#itemName");
            const modalPath = modal.querySelector("#itemPath");
            const modalFileName = modal.querySelector("#fileName");
            const modalFileUrl = modal.querySelector("#fileUrl");
            const mediaIdInput = modal.querySelector("#mediaIdToDelete");
            const galleryListEl = document.querySelector("#galleryListEl");
            const loadMoreBtn = document.getElementById("loadMoreGallery");

            let page = 1;

            const stopPropagation = (e) => {
                e.preventDefault();
                e.stopPropagation();
            };

            const showModal = () => {
                modal.style.display = "block";
            };

            const hideModal = () => {
                modal.style.display = "none";
            };

            const deactivateLoadBtn =(status)=>{
                loadMoreBtn.disabled = status;
            }

            document.body.addEventListener("dblclick", (e) => {
                const target = e.target.closest(".itemGallery");
                if (!target) return;

                modalPrev.innerHTML = "";
                modalPrev.appendChild(target.cloneNode(true));

                modalUser.value = target.dataset.user || "";
                modalName.value = target.dataset.name || "";
                modalPath.value = target.dataset.path || "";
                modalFileName.value = target.dataset.file_name || "";
                modalFileUrl.value = target.getAttribute("src") || "";
                mediaIdInput.value = target.dataset.id || "";

                showModal();
            });

            modal.addEventListener("dblclick", hideModal);
            modalBox.addEventListener("dblclick", stopPropagation);
            closeBtn.addEventListener("click", (e) => {
                e.preventDefault();
                hideModal();
            });

            loadMoreBtn?.addEventListener("click", async (e) => {
                e.preventDefault();
                deactivateLoadBtn(true)
                try {
                    const type = new URLSearchParams(window.location.search).get("type") || "image";
                    const {data} = await axios.get(`/tkadmin/ajax/file-media?type=${type}&page=${page}`);

                    if (data.files?.length) {
                        galleryListEl.insertAdjacentHTML("beforeend",
                            data.files.map(
                                ({id, url, name, file_name, user_id, path}) => `
                            <li class="border border-zinc-300 rounded aspect-square min-w-fit w-fit">
                                <img class="itemGallery" src="${url}" data-id="${id}"
                                     data-name="${name}" data-file_name="${file_name}"
                                     data-user="${user_id}" data-path="${path}" width="200" height="auto"
                                     alt="${file_name}" fetchpriority="low" decoding="async" loading="lazy">
                            </li>`
                            )
                                .join("")
                        );
                        page++;

                    }else{
                        loadMoreBtn.remove();
                    }
                } catch (err) {
                    console.error(err);
                }finally {
                    deactivateLoadBtn(false)
                }
            });
        });

    </script>
@endpush
@push('headerScripts')
    <style>
        #modalPrev * {
            width: 100%;
            height: auto;
            user-select: none;
        }
    </style>
@endpush

