<section id="{{ $block }}" class="c-container {{ $block }}">
    <div class="{{ $block }}__column {{ $block }}__column--left">
        <h2 class="c-purple-dark">{!! $title !!}</h2>
        <p class="{{ $block }}__desc">
            {!! $desc !!}
        </p>
        <a href="{{ getLink($ref['link']) }}" class="c-font-subtitle c-purple-dark {{ $block }}__link">
            {!! $ref['caption'] !!}
        </a>
    </div>
    <div class="{{ $block }}__column {{ $block }}__column--right">
        @include('component.picture', $img)
    </div>
</section>
