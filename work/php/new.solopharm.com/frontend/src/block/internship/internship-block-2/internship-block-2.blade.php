<section class="{{ $block }}">
    <img class="{{ $block->elem('column')->mod('img') }}" src="/storage/{{ $page->block_2_img }}"
        alt="{{ __('pages.photo') . ' ' .$page->block_2_title }}" title="{{ $page->block_2_title }}" />
    <div class=" {{ $block->elem('column')->mod('desc') }}">
        <div>
            <p class="{{ $block->elem('title') }}">
                {!! $page->block_2_title !!}
            </p>
            <p class="{{ $block->elem('text') }}">
                {!! $page->block_2_desc !!}
            </p>
        </div>
        <div>
            {!! $renderer->renderBlock('common/button', [
                'text' => $page->block_2_btn,
                'url' => $page->block_2_action,
                'icon' => 'arrow-long',
            ]) !!}
        </div>
    </div>
</section>
