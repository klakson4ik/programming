<div class="{{ $block }}">
    <a href="{{ getLink('/blogs/' . $code) }}">
        <div class="{{ $block }}__wrapper-img">
            <img class="{{ $block }}__image" src="{{ $img }}" alt="{{ $title }}"
                title="{{ $title }}">
        </div>
        <p class="c-font-subtitle c-black {{ $block }}__title">{!! $title !!}</p>
    </a>
    <div class="c-black {{ $block }}__desc">
        {!! $description !!}
    </div>
</div>
