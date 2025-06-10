<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page->title !!}</h1>

    <div class="{{ $block->elem('block-1') }}">
        {!! $renderer->renderBlock('production/production-title-img', [
            'pageData' => $page,
        ]) !!}
    </div>

    <div class="{{ $block->elem('block-2') }} c-section-margin">
        {!! $renderer->renderBlock('soft-form-plant/block-2', [
            'title' => $page->block_2_title,
            'img' => $page->block_2_img,
            'items' => $page->block_2_data,
        ]) !!}
    </div>

    <div class="{{ $block->elem('block-3') }}">
        {!! $renderer->renderBlock('soft-form-plant/block-3', [
            'img' => $page->block_3_img,
            'items' => $page->block_3_data,
			'subtitle' => $page->block_3_title
        ]) !!}
    </div>
</div>
