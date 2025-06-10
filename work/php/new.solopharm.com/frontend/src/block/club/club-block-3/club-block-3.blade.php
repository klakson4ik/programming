<section class="{{ $block }}">
    <div class="{{ $block->elem('row') }}">
        <h2 class="{{ $block->elem('column')->mod('title') }}">{!! $page->block_2_title !!}</h2>
        <p class="{{ $block->elem('column') }}">{!! $page->block_2_desc !!}</p>
    </div>
    <div class="{{ $block->elem('bottom')}}">
        <img src="/storage/{{ $page->block_2_img}}" class="{{ $block->elem('img')}}" alt="{{__('pages.photo') . ' ' . $page->block_2_title}}" title="{{ $page->block_2_title}}"/>
        <img class="{{ $block->elem('s') }}" src="/images/icons/s-white.svg" />
        <div class="{{ $block->elem('text')}}">
            <p class="{{ $block->elem('text-title')}}">{!! $page->block_2_subtitle!!}</p>
            <p class="{{ $block->elem('text-desc')}}">{!! $page->block_2_text!!}</p>
        </div>
    </div>
</section>
