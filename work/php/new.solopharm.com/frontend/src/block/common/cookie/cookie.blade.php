<div class="{{ $block }}">
    <p class="{{ $block->elem('text') }}">
        {!! __('pages.cookie') !!}
    </p>
    <button class="{{ $block->elem('btn') }}">
        {!! $renderer->renderBlock('common/icon', [
            'icon' => 'cookie',
        ]) !!}
    </button>
</div>
