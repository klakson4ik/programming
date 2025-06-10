<section class="{{ $block }}">
    <p class="{{ $block->elem('text') }}">
        {!! $page->block_3_desc !!}
    </p>
    <div class="{{ $block->elem('btn') }}">
        {!! $renderer->renderBlock('common/button', [
            'url' => $page->block_3_action,
            'text' => $page->block_3_btn,
            'icon' => 'arrow-long',
        ]) !!}
        <img class="{{ $block->elem('s') }}" src="/images/icons/s-dark.svg" />
    </div>
</section>
