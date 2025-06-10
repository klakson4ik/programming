<section class="{{ $block }}">
    <h1 class="c-h1">{!! __('pages.search-page.title') !!}</h1>

    <div class="{{ $block->elem('top') }}">
        <form name="search" class="{{ $block->elem('form') }}" method="get">
            <div class="{{ $block->elem('field') }}">
                {!! $renderer->renderBlock('field/input', [
                    'name' => 'query',
                    'placeholder' => __('pages.search-page.placeholder'),
                    'value' => isset($_GET['query']) ? $_GET['query'] : ''
                ]) !!}
            </div>
            <div class="{{ $block->elem('btn') }}">
                {!! $renderer->renderBlock('common/button', [
                    'type' => 'submit',
                    'text' => __('pages.find'),
                ]) !!}
            </div>
        </form>
        @if ($data)
            <p class="{{ $block->elem('count') }}">
                {!! __('pages.search-page.count') !!}: {{ $count }}
            </p>
        @endif
    </div>
    @if ($data && !$isEmpty)
        <div class="{{ $block->elem('items') }}">
            @foreach ($data as $list)
                @foreach ($list as $item)
                    {!! $renderer->renderBlock('search/search-item', [
                        'title' => $item->title,
                        'text' => $item->getTable() == 'products' ? ($item->indications ?: $item->scope) : $item->text,
                        'url' => locale() . ($item->getTable() == 'products' ? 'products/' . $item->url_slug : ('about/' . $item->getTable() . '/' . $item->url_slug)),
                        'tag' => __('pages.search-page.tag.' . $item->getTable()),
                    ]) !!}
                @endforeach
            @endforeach
        </div>
    @elseif($data && $isEmpty)
        <p class="{{ $block->elem('nothing') }}">
            {!! __('pages.nothing') !!}        
        </p>
    @endif
</section>
