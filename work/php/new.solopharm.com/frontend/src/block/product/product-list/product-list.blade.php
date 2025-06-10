<div class="{{ $block }}">
    <div class="{{ $block->elem('items')->mod($products->count() < 3 ? 'left' : '') }}">
        @foreach ($products as $item)
            <div class="{{ $block->elem('item') }}">
                {!! $renderer->renderBlock('product/product-list-item', [
                    'data' => $item,
                ]) !!}
            </div>
        @endforeach
    </div>
</div>
