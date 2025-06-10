<div class="{{ $block }}">
    <h1 class="c-h1">{{ $page->title }}</h1>
    @isset($sites)
        <section class="b-gallery__sites">
            {!! $renderer->renderBlock('gallery/sites', [
                'sites' => $sites,
            ]) !!}
        </section>
    @endisset
</div>