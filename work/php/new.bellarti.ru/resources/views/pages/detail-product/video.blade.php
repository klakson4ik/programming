<section class="c-container {{ $block }}" data-id="{{ $videoId }}" id="{{ $block }}">
    <h2 class="c-purple-dark {{ $block }}__title">{{ $title }}</h2>
    <div class="{{ $block }}__wrapper">
        {!! $html !!}
    </div>
    @if ($uniqueVideosFlag)
        <button class="c-link {{ $block }}__link">{{ $button }}</button>
    @endif
</section>
