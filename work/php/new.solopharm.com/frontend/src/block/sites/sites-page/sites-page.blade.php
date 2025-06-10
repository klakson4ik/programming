<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page->block_1_title !!}</h1>
    {!! $renderer->renderBlock('sites/sites', [
        'page' => $page,
    ]) !!}
	@if($page->control_quality_title)
    <div class="{{ $block->elem('quality') }}">
        {!! $renderer->renderBlock('sites/quality-control', [
            'page' => $page,
        ]) !!}
    </div>
	@endif
    @isset($sites)
        <h2 class="c-h2">{!! $page->block_3_title !!}</h2>
        <section class="b-sites__items">
            {!! $renderer->renderBlock('sites/sites-items', [
                'sites' => $sites,
            ]) !!}
        </section>
    @endisset
</div>
