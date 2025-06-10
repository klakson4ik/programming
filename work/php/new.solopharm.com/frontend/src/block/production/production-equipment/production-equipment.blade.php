<div class="{{ $block }}">
    {!! $renderer->renderBlock('production/production-header-eq', [
        'pageData' => $pageData,
    ]) !!}
    {!! $renderer->renderBlock('production/production-slider-eq', [
        'pageData' => $pageData,
        'eqP' => $eqP,
    ]) !!}
    {!! $renderer->renderBlock('production/production-two-cols-eq', [
        'pageData' => $pageData,
    ]) !!}
    {!! $renderer->renderBlock('production/production-slider-bottom-eq', [
        'eq' => $eq,
    ]) !!}
</div>