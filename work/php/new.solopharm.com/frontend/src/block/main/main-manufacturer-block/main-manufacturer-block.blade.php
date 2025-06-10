<div class="{{ $block }} c-container">
    <div class="{{ $block->elem('header') }}">
        <h2 class="c-h1">{{ $title }}</h2>
    </div>

    <p class="{{ $block->elem('desc')}}">
        {{ $text }}
    </p>

    <div class="swiperMf">
        <div class="{{ $block->elem('nav') }}">
            <div class="{{ $block->elem('nav-action') }}">
                <span class="{{ $block->elem('nav-left') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                        'left' => true,
                    ]) !!}
                </span>
                <span class="{{ $block->elem('nav-right') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button'
                    ]) !!}
                </span>
            </div>
        </div>
        <div class="swiper-wrapper">

            @foreach ($block6 as $item)
                <a href="{{ $item->link }}" class="swiper-slide" target="_blank">

                    <div class="imgarea">
                        <h3>{{ $item->name }}</h3>
                        <img width="228px" loading="lazy" title="{{ $item->name }}" alt="{{ __('pages.photo') }} {{ $item->name }}"
                            src="{{ asset('storage/' . $item->img) }}" alt="">
                    </div>
                    <p>
                        {{ $item->text }}
                    </p>
                </a>
            @endforeach

        </div>
    </div>
</div>
