<div class="{{ $block }} c-section-margin">
    <div class="{{ $block->elem('slider') }}">
        <div class="swiper-wrapper">

            @foreach ($chronology as $item)
                <div data-start="{{ $item->start_point }}" class="swiper-slide">
                    <p class="{{ $block->elem('date') }}">{{ $item->date }}</p>
                    <p class="{{ $block->elem('text') }}">{!! $item->text !!}</p>
                </div>
            @endforeach
        </div>
    </div>
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
                    'type' => 'button',
                ]) !!}
            </span>
        </div>
    </div>
</div>
