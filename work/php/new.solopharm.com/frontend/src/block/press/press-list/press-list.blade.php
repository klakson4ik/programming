<div class="{{ $block }}">
    {!! $renderer->renderBlock('press/press-header', [
        'news' => $pressPage->tab_1,
        'press' => $pressPage->tab_2,
        'text' => $pressPage->title,
        'type' => 'press',
    ]) !!}
    <div class="c-container">

        @foreach ($press as $item)
            {!! $renderer->renderBlock('press/press-item', [
                'img' => $item->img,
                'url' => $item->url_slug,
                'text' => $item->title,
                'date' => strtotime($item->date),
                'months' => $months,
            ]) !!}
        @endforeach

    </div>
    @if ($press->hasPages())
        <div class="b-product__pagination">
            {{ $press->links() }}
        </div>
    @endif
    {!! $renderer->renderBlock('press/press-pagination', [
        'text' => $pressPage->btn_caption,
        'url' => $pressPage->btn_url,
    ]) !!}
</div>