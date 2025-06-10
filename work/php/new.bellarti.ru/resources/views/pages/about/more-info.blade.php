<section class="{{ $block }}" id="{{ $block }}">
    <div class="c-container {{ $block }}__wrapper">
        <h2 class="c-purple-dark {{ $block }}__title">{{ $title }}</h2>

        <div class="{{ $block }}__items">
            @foreach ($items as $item)
                <div class="{{ $block }}__item">
                    <h2 class="c-purple {{ $block }}__item-number" data-number="{{ $item['number'] }}">
                        {{ $item['number'] }}</h2>
                    <p class="{{ $block }}__item-text">{!! $item['text'] !!}</p>
                </div>
            @endforeach
        </div>

        <div class="{{ $block }}__image-container">
            <img src="{{ $image }}" alt="{{ $title }}" class="{{ $block }}__image">
            <div class="{{ $block }}__info">
                @foreach ($info as $element)
                    <div class="{{ $block }}__info-item">
                        <p class="{{ $block }}__info-text">{!! $element['icon'] !!} {!! $element['text'] !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
