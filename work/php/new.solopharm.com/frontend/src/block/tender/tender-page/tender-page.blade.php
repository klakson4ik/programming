<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page->title !!}</h1>
    <div class="c-section-margin">
        {!! $renderer->renderBlock('tender/tender-text', [
            'page' => $page,
        ]) !!}
    </div>
    <h2 class="c-h2">{!! $page->subtitle !!}</h2>
    {!! $renderer->renderBlock('tender/tender-procedures', [
        'page' => $page,
    ]) !!}
</div>