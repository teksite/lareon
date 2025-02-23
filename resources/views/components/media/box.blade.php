<div class="fixed bg-zinc-800/75 inset-0 w-full h-full z-10 flex items-center justify-center select-none" id="modalGallery" style="display: none" data-target_id="">
    <div class="w-11/12 max-h-[90%] overflow-y-auto relative overflow mx-auto my-12 bg-white p-6 rounded-lg" id="modalGalleryBox">
        <button id="closeGalleyModal" type="button" role="button" class="absolute z-20 top-1  end-3 text-red-600 font-bold shadow p-1 bg-white rounded">
            X
        </button>
        <div class="mx-auto flex items-start gap-6 ">
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
                    @foreach($files ?? [] as $file)
                        <li class="border border-zinc-300 rounded aspect-square min-w-fit w-fit">
                            @if( str_starts_with($file->mime_type, 'image'))
                                <img class="itemGallery" src="{{$file->url}}" data-id="{{$file->id}}" data-name="{{$file->name}}" data-file_name="{{$file->file_name}}"
                                     data-user="{{$file->user_id}}" data-path="{{$file->path}}" width="200" height="auto" alt="{{$file->file_name}}" fetchpriority="low" decoding="async" loading="lazy">
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
                                   data-file_name="{{$file->file_name}}" data-user="{{$file->user_id}}"
                                   data-target="_blank">
                                    <img src="" alt="" width="200" height="200" fetchpriority="low" decoding="async"
                                         loading="lazy">
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
    </div>
</div>

@push('footerScripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("modalGallery");
            if (!modal) return;

            const modalBox = modal.querySelector("#modalGalleryBox");
            const closeBtn = modal.querySelector("#closeGalleyModal");
            const galleryListEl = modal.querySelector("#galleryListEl");


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

            const deactivateLoadBtn = (status) => {
                loadMoreBtn.disabled = status;
            }


            modal.addEventListener("dblclick", hideModal);
            modalBox.addEventListener("dblclick", stopPropagation);
            closeBtn.addEventListener("click", (e) => {
                e.preventDefault();
                hideModal();
            });

            const resetItemDetector = () =>{
                return document.querySelectorAll('.itemGallery')
            }


            function copySrctoInputEvent(){
                let  galleryItems=resetItemDetector();
                if(galleryItems.length){
                    galleryItems.forEach(item=>{
                        item.addEventListener('dblclick',e=>{
                            e.preventDefault();

                           const file = item.closest('.itemGallery');
                           const src= file.getAttribute('src')
                           const id= modal.getAttribute('data-target_id');
                            console.log(src , id)
                            console.log( document.getElementById('prev_'+id) ,  document.getElementById('input_'+id))
                            const preEl= document.getElementById('prev_'+id)
                            if(preEl) preEl.src=src;
                            document.getElementById('input_'+id).value=src;
                            hideModal();
                        })
                    })
                }

            }



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

                    } else {
                        loadMoreBtn.remove();
                    }
                } catch (err) {
                    console.error(err);
                } finally {
                    deactivateLoadBtn(false);
                    copySrctoInputEvent();
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

