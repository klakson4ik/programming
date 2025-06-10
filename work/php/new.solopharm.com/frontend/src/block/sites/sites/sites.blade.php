<div class="{{ $block }}">
    <div class="{{ $block->elem('header') }}">
        <img src="/storage/{{ $page->img }}" class="{{ $block->elem('header-img') }}"
            alt="{{ __('pages.photo') . ' ' . strip_tags($page->block_1_title) }}"
            title="{{ strip_tags($page->block_1_title) }}" />
        <img src="/images/icons/s-dark.svg" class="{{ $block->elem('header-s') }}" />
    </div>
    <h2 class="c-h2">{!! $page->block_2_title !!}</h2>
    <div class="{{ $block->elem('row') }}">
        <div class="{{ $block->elem('column') }}">
            @isset($page->block_2_data)
                @foreach ($page->block_2_data as $item)
                    <div class="{{ $block->elem('block-2-data') }}">
                        <p class="{{ $block->elem('block-2-data-item') }}">
                            {!! $item['value'] !!}
                        </p>
                    </div>
                @endforeach
            @endisset
        </div>
        <div class="{{ $block->elem('column') }}">
            <p class="{{ $block->elem('block-2-desc') }}">
                {!! $page->block_2_desc !!}
            </p>
            <img src="/storage/{{ $page->block_2_img }}" class="{{ $block->elem('block-2-img') }}"
                alt="{{ __('pages.photo') }} GMP" title="GMP" />
        </div>
    </div>
    <h2 class="c-h2">{{ $page->block_1_subtitle }}</h2>
    <div class="{{ $block->elem('row') }}">
        @isset($page->block_1_data)
            @foreach ($page->block_1_data as $item)
                <div class="{{ $block->elem('column') }}">
                    <div class="{{ $block->elem('block-1-data-item') }}">
                        <p class="{{ $block->elem('block-1-data-item-title') }}">
                            {!! $item['title'] !!}
                        </p>
                        <p>
                            {!! $item['value'] !!}
                        </p>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</div>
