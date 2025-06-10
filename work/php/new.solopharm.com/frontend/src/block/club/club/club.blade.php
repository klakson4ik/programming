<div class="{{ $block }}">
    <div class="c-border-bottom">
        {!! $renderer->renderBlock('club/club-block-2', [
            'page' => $page,
            'data' => $arrangements,
        ]) !!}
    </div>
    <div class="c-border-bottom">
        {!! $renderer->renderBlock('club/club-block-3', [
            'page' => $page,
        ]) !!}
    </div>
    {!! $renderer->renderBlock('club/club-block-4', [
        'page' => $page,
        'data' => $premises,
    ]) !!}
</div>