<div class="{{ $block }}">
    <h1 class="c-h1">{!! $pageData->block_1_title !!}</h1>

    {!! $renderer->renderBlock('production/production-title-img', [
        'pageData' => $pageData,
    ]) !!}

    {!! $renderer->renderBlock('production/production-info-biotech', [
        'eq' => $eq,
        'pageData' => $pageData,
    ]) !!}
</div>