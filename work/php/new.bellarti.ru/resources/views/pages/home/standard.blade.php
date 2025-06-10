<section id="{{ $block }}" class="c-container {{ $block }}">
    <div class="{{ $block }}__column">
        <h2>{!! $title !!}</h2>
        <p class="{{ $block }}__desc">
            {!! $desc !!}
        </p>
    </div>
    @isset($video)
        <div class="{{ $block }}__column--video">
            @include('component.video', $video)
        </div>
    @endisset
</section>
