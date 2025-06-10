<div class="{{ $block }}">
    <div class="{{ $block->elem('coll') }}">
        <h2 class="{{ $block->elem('header') }} c-h2" > {!! $pageData->block_1_title !!}</h2>
    </div>
    <div class="{{ $block->elem('coll') }}">
        <p class="{{ $block->elem('text') }} c-text">
            {!! $pageData->block_1_text !!}
        </p>
    </div>
</div>
