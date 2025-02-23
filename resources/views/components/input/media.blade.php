@props(['name' , 'placeholder'=>'avatar' ,'value'=>null , 'width'=>400 , 'height'=>400 ,'prev'=>null])
@php
    $rand=rand(1000,9999);
    $plc=match (true){
      $placeholder==='avatar'=>  "/lareon/avatar.avif",
      default=>"/lareon/no-cover.avif"
    };
@endphp
<div>
   @if($prev)
      <div class="relative">
          @if($prev==='image')
              <img src="{{$value ?? $plc}}"  alt="{{$value ?? $plc}}" id="prev_{{$rand}}" class="preview_gallery w-full"  data-id="{{$rand}}">

          @elseif($prev==='video')
              <video src="{{$value ?? $plc}}" controls id="prev_{{$rand}}" class="preview_gallery"  data-id="{{$rand}}"></video>
          @endif
          <div class="absolute top-0 end-0 bg-zinc-900/50 text-white font-bold text-xs p-1">{{$width}}x{{$height}}</div>
      </div>
   @endif
    <input dir="ltr" id="input_{{$rand}}" name="{{$name}}" value="{{$value ?? ''}}" class="input input_gallery" data-id="{{$rand}}">
    <button
        class="w-full block text-center text-blue-600 shadow-lg bg-white font-semibold text-sm p-3 rounded-lg border border-slate-200 singleMediaBtn"
        data-input="input_{{$rand}}" data-id="{{$rand}}" data-prev="pre_{{$rand}}">
        {{__('choose')}}
    </button>
</div>
<x-lareon::media.box :target="$rand"/>

@push('footerScripts')
    <script>
        const inputEls = document.querySelectorAll('.input_gallery');
        const singleMediaBtns = document.querySelectorAll('.singleMediaBtn');
        singleMediaBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const targetId = btn.getAttribute('data-id');
                const modal = document.getElementById('modalGallery')
                modal.setAttribute('data-target_id', targetId);
                modal.style.display = 'block'
            })
        });
        console.log(inputEls)
        inputEls.forEach(input => {
            input.addEventListener('change', e => {
                e.preventDefault();
                const targetId = input.getAttribute('data-id')
                const preEl = document.getElementById('prev_' + targetId)
                if (preEl) {
                    console.log(preEl)
                    preEl.src = e.target.value;
                    preEl.alt = e.target.value;
                }
            })
        });
    </script>
@endpush

