<div class="c-rel b-video">
    <div class="video-block">
        {!! getCommonIcon('preloader') !!}
    </div>
    @if ($video_vk)
        <div class="b-video__vk-video">
            <iframe src="{{ $video_vk }}" encrypted-media fullscreen picture-in-picture frameborder="0"
                allowfullscreen></iframe>
        </div>
    @elseif ($video)
        <div class="b-video__video">
            <video src="/storage/{{ $video }}" type="video/{!! getExt($video) !!}" controls preload="metadata"
                @if (isset($preview)) poster="{!! $preview !!}" @endif>
                Ошибка открытия файла
                <a href="/storage/{{ $video }}">download it</a>
                and watch it with your favorite video player!
            </video>
        </div>
    @endif
</div>
