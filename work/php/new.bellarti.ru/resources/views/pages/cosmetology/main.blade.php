<section id="{{ $block }}" class="{{ $block }}">
    <div class="{{ $block }}__picture">
        @include('component.picture', $img)
    </div>
    <div class="c-container {{ $block }}__info">
        <h2 class="{{ $block }}__title c-h1">
            {!! $title !!}
        </h2>
        <a href="{{ $btn['link'] }}" class="c-uppercase c-bg-purple c-white smooth-scroll {{ $block }}__btn">
            {!! $btn['caption'] !!}
        </a>
    </div>
</section>
