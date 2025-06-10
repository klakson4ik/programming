<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page->block_1_title !!}</h1>
    <div class="c-section-margin">
        {!! $renderer->renderBlock('internship-laboratory/laboratory-block-1', [
            'page' => $page,
        ]) !!}
    </div>
    <h2 class="c-h2">{!! $page->block_2_title !!}</h2>
    <div class="c-section-margin">
        {!! $renderer->renderBlock('internship-laboratory/laboratory-block-2', [
            'page' => $page,
            'laboratories' => $laboratories,
        ]) !!}
    </div>
    <h2 class="c-h2">{!! $page->block_3_title !!}</h2>
    {!! $renderer->renderBlock('internship-laboratory/laboratory-block-3', [
        'page' => $page,
    ]) !!}
</div>