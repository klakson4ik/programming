<section class="c-container {{ $block }}" id="{{ $block }}">
    <div class="{{ $block }}__content">
        {!! $desc !!}
    </div>
    @if ($video)
        <div class="{{ $block }}__video">
            @include('component.video', $video)
        </div>
    @endif
</section>
