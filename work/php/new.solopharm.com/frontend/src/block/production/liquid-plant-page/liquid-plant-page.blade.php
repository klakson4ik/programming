<div class="{{ $block }}">
    <h1 class="c-h1">{!! $pageData->title !!}</h1>
    {!! $renderer->renderBlock('production/production-title-img', [
        'pageData' => $pageData,
    ]) !!}

    <h2 class="c-h2">{!! $pageData->block_2_title !!}</h2>

    {!! $renderer->renderBlock('production/production-title-text', [
        'text' => $pageData->block_2_text_2,
    ]) !!}

    {!! $renderer->renderBlock('production/production-info-liquidplan', [
        'pageData' => $pageData,
    ]) !!}
</div>