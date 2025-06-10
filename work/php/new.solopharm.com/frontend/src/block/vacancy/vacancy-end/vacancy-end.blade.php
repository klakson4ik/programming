<section class="{{ $block }}">
    <p class="{{ $block->elem('text') }}">
        {!! $page->block_2_desc !!}
    </p>
    {!! $renderer->renderBlock('common/button', [
        'text' => $page->block_2_btn,
        'url' => $page->block_2_action,
        'icon' => 'arrow-long',
    ]) !!}
</section>
