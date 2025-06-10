<div class="{{ $block }}">
    {!! $renderer->renderBlock('press/press-header', [
        'news' => $pressPage->tab_1,
        'press' => $pressPage->tab_2,
        'text' => $pressPage->title,
        'type' => 'news',
    ]) !!}
    <div class="c-container">
        @foreach ($news as $item)
            {!! $renderer->renderBlock('press/news-item', [
                'img' => $item->img,
                'url' => $item->url_slug,
                'text' => $item->title,
            ]) !!}
        @endforeach
    </div>
    @if ($news->hasPages())
        <div class="b-product__pagination">
            {{ $news->links() }}
        </div>
    @endif

    {!! $renderer->renderBlock('press/press-pagination', [
        'text' => $pressPage->btn_caption,
        'url' => $pressPage->btn_url,
    ]) !!}
</div>