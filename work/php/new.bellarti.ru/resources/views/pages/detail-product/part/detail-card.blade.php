@if (isset($images['src']))
    <a href="{{ getLink('/product/' . $parentElement) }}/{{ $url }}"
        class="{{ $block }}__link {{ request()->is('product/' . $parentElement . '/' . $url) ? 'c-border-purple-dark inactive' : '' }}">
        <img class="{{ $block }}__image-minimaze" src="{{ $images['src'] }}" alt="{{ $name }}"
            data-slidename="{{ $count }}">
    </a>
@else
    <a href="{{ getLink('/product/' . $parentElement) }}/{{ $url }}"
        class="{{ $block }}__link {{ request()->is('product/' . $parentElement . '/' . $url) ? 'c-border-purple-dark inactive' : '' }}">
        <img class="{{ $block }}__image-minimaze" src="{{ $images }}" alt="{{ $name }}"
            data-slidename="{{ $count }}">
    </a>
@endif
