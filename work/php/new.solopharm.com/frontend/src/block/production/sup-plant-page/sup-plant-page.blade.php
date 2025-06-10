<div class="{{ $block }}">
    <h1 class="c-h1 ">{!! $pageData->title !!}</h1>

    {!! $renderer->renderBlock('production/production-title-img', [
        'pageData' => $pageData,
    ]) !!}

    {!! $renderer->renderBlock('production/production-info-supplant', [
        'pageData' => $pageData,
        'supdSys' => $supdSys,
    ]) !!}
</div>