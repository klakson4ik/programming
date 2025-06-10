<section class="{{ $block }}">
    <div class="{{ $block->elem('row') }}">
        <div class="{{ $block->elem('column')->mod('slider') }}">
            <div class="{{ $block->elem('slider') }}">
                @foreach ($data as $key => $item)
                    <img class="{{ $block->elem('slide')->mod($key == 0 ? 'active' : '') }}" data-id="{{ $key }}"
                        src="/storage/{{ $item->img }}" alt="{{ __('pages.photo') . ' ' . $item->title }}"
                        title="{{ $item->title }}" />
                @endforeach
            </div>
        </div>
        <div class=" {{ $block->elem('column')->mod('desc') }}">
            <div class="{{ $block->elem('column-top') }}">
                <p class="{{ $block->elem('caption') }}">{!! $page->block_3_text !!}</p>
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
                        @isset($item->caption)
                            <div class="{{ $block->elem('desc-item-video') }}">
                                {!! $renderer->renderBlock('common/button', [
                                    'type' => 'button',
                                    'text' => $item->caption,
                                    'icon' => 'watch',
                                ]) !!}

                                @if (isset($item->url) && $item->url == 'panorama')
                                    {!! $renderer->renderBlock('/partials/popup', [
                                        'panorama' => $item->url,
                                    ]) !!}
                                @endif
                            </div>
                        @endisset
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
