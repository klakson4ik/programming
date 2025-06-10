<section class="{{ $block }}">
    <h1 class="{{ $block->elem('column')->mod('title') }} c-h1">{!! $page->block_1_title !!}</h2>
    <div class="{{ $block->elem('top-text') }}">{!! $page->top_text !!}</div>
    <div class="{{ $block->elem('row') }}">
        <div class="{{ $block->elem('column')->mod('slider') }}">
            <div class="{{ $block->elem('slider') }}">
                @foreach ($data as $key => $item)
                    <img class="{{ $block->elem('slide')->mod($key == 0 ? 'active' : '') }}"
                        src="/storage/{{ $item->img }}" alt="{{ __('pages.photo') . ' ' . $item->title }}"
                        title="{{ $item->title }}" data-id="{{ $key }}" />
                @endforeach
            </div>
        </div>
        <div class=" {{ $block->elem('column') }}">
            <div class="{{ $block->elem('column-top') }}">
                <p class="{{ $block->elem('caption') }}">{!! $page->block_1_text !!}</p>
                <div class="{{ $block->elem('nav') }}">
                    <span class="{{ $block->elem('nav-prev') }}">
                        {!! $renderer->renderBlock('common/arrow', [
                            'type' => 'button',
                            'left' => true,
                        ]) !!}
                    </span>
                    <span class="{{ $block->elem('nav-next') }}">
                        {!! $renderer->renderBlock('common/arrow', [
                            'type' => 'button',
                        ]) !!}
                    </span>
                </div>
            </div>
            <div class="{{ $block->elem('desc') }}">
                @foreach ($data as $key => $item)
                    <div class="{{ $block->elem('desc-item')->mod($key == 0 ? 'active' : '') }}"
                        data-id="{{ $key }}">
                        <p class="{{ $block->elem('desc-item-title') }}">
                            {!! $item->title !!}
                        </p>
                        <p class="{{ $block->elem('desc-item-desc') }}">
                            {!! $item->desc !!}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
