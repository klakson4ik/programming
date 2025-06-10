<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark">{!! $title !!}</h2>
    <p class="{{ $block }}__desc">
        {!! $desc !!}
    </p>
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
</section>
