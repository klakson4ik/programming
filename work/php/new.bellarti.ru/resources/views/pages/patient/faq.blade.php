<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark">{!! $title !!}</h2>
    <div class="{{ $block }}__items">
        @foreach ($items as $item)
            <div class="{{ $block }}__item item">
                <div class="{{ $block }}__header">
                    <p class="c-trans-color c-purple-dark c-h4 {{ $block }}__caption">
                        {!! $item['title'] !!}
                    </p>
                    <button class="c-purple-dark {{ $block }}__icon icon">
                        {!! $icon !!}
					</button>
                </div>
                <div class="{{ $block }}__dropdown dropdown">
                    <p class="{{ $block }}__text">
                        {!! $item['description'] !!}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>
