<section class="{{ $block }}">
    <p class="{{ $block->elem('desc') }}"> {!! $page->block_1_desc !!}</p>
    <div class="{{ $block->elem('main') }}">
        <img class="{{ $block->elem('main-img') }}" src="/storage/{{ $page->img }}" alt="{{ __('pages.photo') . ' ' . $page->block_1_title }}"
            title="{{ $page->block_1_title }}" />

        <img class="{{ $block->elem('main-s') }}" src="/images/icons/s-white.svg" />
    </div>
    <p class="{{ $block->elem('subtitle') }}">
        {!! $page->block_1_subtitle !!}
    </p>
    <div class="{{ $block->elem('data') }}">
        @foreach ($page->block_1_data as $item)
            <p class="{{ $block->elem('data-item') }}">{!! $item['value'] !!}</p>
        @endforeach
    </div>
</section>
