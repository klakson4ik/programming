<section class="{{ $block }}">
    <p class="{{ $block->elem('desc') }}"> {!! $page->desc !!}</p>
    <div class="{{ $block->elem('bottom') }}">
        <img class="{{ $block->elem('img') }}" src="/storage/{{ $page->block_1_img }}" alt="{{ __('pages.photo') . ' ' . $page->title }}"
            title="{{ $page->title }}" />
        <div class="{{ $block->elem('text') }}">
            <p class="{{ $block->elem('text-title') }}">
                {!! $page->block_1_title !!}
            </p>
            <p class="{{ $block->elem('text-desc') }}">
                {!! $page->block_1_desc !!}
            </p>
        </div>
    </div>
</section>
