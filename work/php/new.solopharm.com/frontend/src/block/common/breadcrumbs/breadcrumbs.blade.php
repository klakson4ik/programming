@php
    $lastKey = array_key_last($data);
@endphp
<ul class="{{ $block }} c-container" itemscope="" itemtype="http://schema.org/BreadcrumbList">
    <li class="{{ $block->elem('item') }}" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
        <a itemprop="item" href="/">
            <span itemprop="name">{{ __('pages.breadcrumbs.main') }}</span>
            {!! $renderer->renderBlock('common/icon', [
                'icon' => 'arrow-short',
            ]) !!}
        </a>
        <meta itemprop="position" content="1">
    </li>
    @if ($data)
        @foreach ($data as $key => $item)
            <li class="{{ $block->elem('item')->mod(!next($data) ? 'active' : '') }}" itemprop="itemListElement"
                itemscope="" itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{ (locale() == '' ? '' : '/' . app()->getLocale()) . $item['url'] }}">
                    <span itemprop="name">{{ $item['name'] }}</span>
                    @if ($key != $lastKey)
                        {!! $renderer->renderBlock('common/icon', [
                            'icon' => 'arrow-short',
                        ]) !!}
                    @endif
                </a>
                <meta itemprop="position" content="{{ $key + 2 }}">
            </li>
        @endforeach
    @endif
</ul>
