<div class="{{ $block }}">
    <h1 class="c-h1">{{ $product->title }}</h1>
    <div class="b-product-item__header">
        <div class="b-product-item__header-left">
            @if (isset($product->direction->svg))
                <img src="/storage/{{ $product->direction->svg }}">
            @endif
            @if (isset($product->direction->name))
                <span>{{ $product->direction->name }}
            @endif
        </div>
        <div class="b-product-item__header-right">
            {!! $renderer->renderBlock('partials/social-share/social-share-btn', [
                'socialShare' => $socialShare,
            ]) !!}
        </div>
    </div>
    <div class="b-product-item__row">
        <div class="b-product-item__column-left">
            {!! $renderer->renderBlock('product-item/product-item-description', [
                'product' => $product,
                'trades' => $trades,
                'currentTrade' => $currentTrade,
                'socialShare' => $socialShare,
            ]) !!}
        </div>
        <div class="b-product-item__column-right">
            {!! $renderer->renderBlock('product-item/product-item-dynamic', [
                'product' => $product,
                'catalog_page' => $catalogPage,
                'trades' => $trades,
                'currentTrade' => $currentTrade,
                'links' => $links
            ]) !!}
        </div>
    </div>
    <a href="/{{ locale() . routeName() }}" class="b-product-item__backurl">
        {!! $renderer->renderBlock('common/icon', [
            'icon' => 'arrow-left',
        ]) !!}
        <span>{{ __('pages.product.backurl') }}</span>
    </a>
</div>