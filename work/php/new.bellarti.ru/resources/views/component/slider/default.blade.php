<div class="{{ $block }}__swiper-container">
    <div class="{{ $block }}__swiper">
        <div class="{{ $block }}__cards {{ $block }}__wrapper">
            @foreach ($cards as $card)
                <div class="{{ $block }}__card {{ $block }}__slide">
                    @include($cardTemplate, $card, [
                        'block' => $block . '-card',
                        'card' => $cardData ?? false,
                    ])
                </div>
            @endforeach

        </div>
    </div>
    @isset($action)
        <div class="{{ $block }}__action">
            @include('component.slider.action.' . $action)
        </div>
    @endisset
</div>
