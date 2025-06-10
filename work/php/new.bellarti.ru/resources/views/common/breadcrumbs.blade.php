@php
    if (isset($breadcrumbsAdd)) {
        $data = array_merge($data, $breadcrumbsAdd);
    }
@endphp
<ul class="b-breadcrumbs {{ $type ?? '' }}" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li class="b-breadcrumbs__item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
        <a class="c-gray" itemprop="item" href="/">
            <span itemprop="name">Главная</span>
        </a>
        <meta itemprop="position" content="1">
    </li>
    @if ($data)
        @foreach ($data as $key => $item)
            <li class="b-breadcrumbs__item {{ !next($data) ? 'b-breadcrumbs__item--active' : '' }}"
                itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a class="c-gray" itemprop="item" href="{{ $item['url'] }}">
                    <span itemprop="name">{{ $item['name'] }}</span>
                </a>
                <meta itemprop="position" content="{{ $key + 2 }}">
            </li>
        @endforeach
    @endif
</ul>
