<div class="{{ $block }}">
    <p class="c-font-subtitle c-bold {{ $block }}__title">{!! $title !!}</p>
    <div class="{{ $block }}__imgs">
        <div class="{{ $block }}__before">
            <img src="{{ $img_before }}" alt="{{ $title }}" title="{{ $title }}">
        </div>
        <div class="{{ $block }}__after">
            <img src="{{ $img_after }}" alt="{{ $title }}" title="{{ $title }}">
        </div>
    </div>
    <p class="c-purple-light c-uppercase {{ $block }}__name">
        {!! $name !!}
    </p>
    <p class="c-gray-light {{ $block }}__town">
        {!! $town !!}
    </p>
    @if ($description)
        <div class="c-rel {{ $block }}__info item">
            <button class="c-trans-color {{ $block }}__btn">
                <span class="{{ $block }}__caption">
                    {!! $card['more']['caption'] !!}
                </span>
                <span class="{{ $block }}__icon icon">{!! $card['more']['icon'] !!}</span>
            </button>
            <div class="{{ $block }}__dropdown dropdown">
                {!! $description !!}
            </div>
        </div>
    @endif
</div>
