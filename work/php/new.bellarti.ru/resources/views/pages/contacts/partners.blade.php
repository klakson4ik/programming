<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark {{ $block }}__title">{{ $title }}</h2>
    <div class="{{ $block }}__wrapper">
        @foreach ($partners as $item)
            <div class="{{ $block }}__wrapper-items">
                <a href="{{ getLink($item['url']) }}" class="{{ $block }}__item" target="_blank" rel="nofollow">
                    <img src="{{ $item['img'] }}" title="{{ $item['title'] ?: $title }}"
                        alt="{{ $item['alt'] ?: $title }}" class="{{ $block }}__item-image">
                </a>
            </div>
        @endforeach
    </div>
</section>
