<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark">{!! $title !!}</h2>
    <div class="{{ $block }}__row">
        <div class="{{ $block }}__column">
            <p class="{{ $block }}__desc">
                {!! $desc !!}
            </p>
            <div class="{{ $block }}__lines">
                <p class="c-font-subtitle {{ $block }}__subtitle">{!! $subtitle !!}</p>
                <div class="{{ $block }}__items">
                    @foreach ($items as $item)
                        <div class="{{ $block }}__item">
                            <div class="{{ $block }}__icon">
                                {!! $item['icon'] !!}
                            </div>
                            <p class="{{ $block }}__caption">
                                {!! $item['caption'] !!}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="{{ $block }}__column {{ $block }}__column--right">
            <img src="{{ $img }}" alt="{{ $title }}">
        </div>
    </div>
</section>
