<a href="{{ getLink('/product/' . $url) }}" class="{{ $block }}">
	<h3 class="c-font-subtitle c-purple-dark c-light">{!! pickFirstWord($name, 'c-bold') !!}</h3>
    <div class="{{ $block }}__picture">
        @include('component.picture', ['img' => $images])
    </div>
    <a href="{{ getLink('/product/' . $url) }}" class="{{ $block }}__link">
        <p class="c-link {{ $block }}__caption">{!! $card['more']['caption'] !!}</p>
        <div class="c-purple-dark {{ $block }}__icon">{!! $card['more']['icon'] !!}</div>
    </a>
</a>
