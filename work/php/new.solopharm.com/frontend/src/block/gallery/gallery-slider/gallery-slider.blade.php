<section class="{{ $block }}">
    <div class="{{ $block->elem('container-slider') }}">
        <div class="{{ $block->elem('slider') }}">
            <div class="swiper-wrapper">
                @foreach ($gallery as $key => $item)
                    <img class="{{ $block->elem('slide') }} swiper-slide" src="/storage/{{ $item->img }}"
                        alt="{{ $title . ' - ' . __('pages.photo') . ' ' . $key + 1 }}"
                        title="{{ $title . ' - ' . __('pages.photo') . ' ' . $key + 1 }}" />
                @endforeach
            </div>
        </div>
        @if ($gallery->count() > 1)
            <div class="{{ $block->elem('nav') }}">
                <div class="{{ $block->elem('nav-area-left') }}">
                </div>
                <div class="{{ $block->elem('nav-area-right') }}">
                </div>
                <button class="{{ $block->elem('nav-left') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'left' => true,
                    ]) !!}
                </button>
                <button class="{{ $block->elem('nav-right') }}">
                    {!! $renderer->renderBlock('common/arrow', []) !!}
                </button>
            </div>
        @endif

    </div>
    <div class="{{ $block->elem('nav-2') }}">
        <div class="{{ $block->elem('nav-action') }}">
            <span class="{{ $block->elem('nav-left') }}">
                {!! $renderer->renderBlock('common/arrow', [
                    'type' => 'button',
                    'left' => true,
                ]) !!}
            </span>
            <span class="{{ $block->elem('nav-right') }}">
                {!! $renderer->renderBlock('common/arrow', [
                    'type' => 'button',
                ]) !!}
            </span>
        </div>
    </div>
    @if ($gallery->count() > 1)
        <div class="{{ $block->elem('container-thumbs') }}">
            <div class="{{ $block->elem('thumbs') }}">
                <div class="swiper-wrapper">
                    @foreach ($gallery as $item)
                        <img class="{{ $block->elem('thumb') }} swiper-slide" src="/storage/{{ $item->img }}"
                            alt="{{ $title . ' - ' . __('pages.photo') . ' ' . $key + 1 }}"
                            title="{{ $title . ' - ' . __('pages.photo') . ' ' . $key + 1 }}" />
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</section>
