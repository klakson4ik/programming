@php
    $block = 'b-card';
@endphp
<div class="{{ $block }} card" itemscope itemtype="https://schema.org/Article">
    <a href="{{ getRouteLink($code) }}">
        <div class="{{ $block }}__img">
            <img src="{{ $img }}" alt="{{ $title }}" title="{{ $title }}" itemprop="image">
        </div>

        <p class="c-font-subtitle c-black c-trans-color {{ $block }}__title" itemprop="headline">
            {!! $title !!}
        </p>
    </a>

    <div class="{{ $block }}__desc">
        @if ($description)
            <div class="c-black {{ $block }}__text" itemprop="articleBody">
                {!! $description !!}
            </div>
        @endif
    </div>
    @if ($date)
        <p class="c-gray-light {{ $block }}__date" itemprop="datePublished" content="{!! $date !!}">
            {!! $date !!}
        </p>
    @endif

</div>
