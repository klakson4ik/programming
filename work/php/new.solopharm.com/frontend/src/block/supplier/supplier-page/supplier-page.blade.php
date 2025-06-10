<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page->title !!}</h1>
    <div class="{{ $block->elem('text') }} c-border-bottom">
        {!! $renderer->renderBlock('supplier/supplier-text', [
            'page' => $page,
        ]) !!}
    </div>
    <h2 class="c-h2">{!! $page->form_title !!}</h2>
    {!! $renderer->renderBlock('form/supplier', [
        'page' => $page,
    ]) !!}
</div>