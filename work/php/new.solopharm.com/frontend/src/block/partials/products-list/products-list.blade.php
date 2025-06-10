<div class="{{ $block }}">
    <div style="width: 100%">
        {!! $renderer->renderBlock('product/product-tags', [
            'directions' => $directions,
            'choiceFilters' => $choiceFilters,
            'directionIds' => isset($directionIds) ? $directionIds : false,
        ]) !!}
        @if ($products->isNotEmpty())
            <div class="{{ $block->elem('products') }}">
                {!! $renderer->renderBlock('product/product-list', [
                    'products' => $products,
                ]) !!}
            </div>
        @else
            <p class="{{ $block->elem('empty') }}">{{ __('pages.nothing') }}</p>
        @endif
    </div>
    @if ($products->hasPages())
        <div class="{{ $block->elem('pagination') }}">
            {{ $products->links() }}
        </div>
    @endif
</div>