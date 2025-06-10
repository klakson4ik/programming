<div class="{{ $block }}">
    <h1 class="b-product__title c-h1">{{ $page->title }}</h1>
    <div class="b-product__mobile c-container">
        <ul class="b-breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li class="b-breadcrumbs__item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="/">
                    <span itemprop="name">{{ __('pages.breadcrumbs.main') }}</span>
                    {!! $renderer->renderBlock('common/icon', [
                        'icon' => 'arrow-short',
                    ]) !!}
                </a>
                <meta itemprop="position" content="1">
            </li>
            <li class="b-breadcrumbs__item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="/products">
                    <span itemprop="name">{{ __('pages.product.title') }}</span>
                </a>
                <meta itemprop="position" content="1">
            </li>
        </ul>
    <h1 class="b-product__mobile-title">{{ $page->title }}</h1>
    <button class="b-product__filter-mobile-btn">
        <span class="b-product__filter-mobile-btn-text">{{ __('pages.product.filter.all') }}</span>
        {!! $renderer->renderBlock('common/icon', [
            'icon' => 'arrow-short',
        ]) !!}
    </button>
    </div>
    <div class="b-product__row">
        <div class="b-product__column-left">
            {!! $renderer->renderBlock('product/product-filter', [
                'directions' => $directions,
                'page' => $page,
                'choiceFilters' => $choiceFilters,
                'directionIds' => $directionIds,
            ]) !!}
        </div>
        <div class="b-product__column-right">
            {!! $renderer->renderBlock('partials/products-list', [
                'directions' => $directions,
                'products' => $products,
                'choiceFilters' => $choiceFilters,
                'directionIds' => $directionIds,
            ]) !!}
        </div>
    </div>
    <div class="b-product__filter-mobile b-product__filter-mobile--inactive c-container">
        {!! $renderer->renderBlock('product/product-filter-mobile', [
            'directions' => $directions,
            'page' => $page,
            'choiceFilters' => $choiceFilters,
            'directionIds' => $directionIds,
            'mobile' => true
        ]) !!}
    </div>
</div>