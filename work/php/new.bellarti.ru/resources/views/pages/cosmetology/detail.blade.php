<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2>{!! $title !!}</h2>
    <div class="{{ $block }}__items">
        @foreach ($items as $item)
            <div class="{{ $block }}__item">
                <div class="c-purple-dark c-font-subtitle {{ $block }}__item-title">
                    {!! $item['title'] !!}
                </div>
                <p class="{{ $block }}__item-text">
                    {!! $item['text'] !!}
                </p>
            </div>
        @endforeach
    </div>
</section>
