<section id="{{ $block }}" class="{{ $block }}" style="background-image: url({{ $bg }})">
    <div class="c-container {{ $block }}__container">
        <h2>{!! $title !!}</h2>
        <div class="{{ $block }}__items">
            @foreach ($items as $item)
                <div class="{{ $block }}__item">
                    <div class="{{ $block }}__icon">
                        {!! $item['icon'] !!}
                    </div>
                    <p class="c-font-subtitle {{ $block }}__caption">
                        {!! $item['text'] !!}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
