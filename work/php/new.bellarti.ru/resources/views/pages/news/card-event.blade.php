@php
    $block = 'b-card-event';
@endphp
<div class="{{ $block }} card" itemscope itemtype="https://schema.org/Event">
    <a href="events/{{ $code }}" class="{{ $block }}__img">
        <img src="{{ $img }}" alt="{{ $title }}" title="{{ $title }}" itemprop="image">
    </a>
    <div class="{{ $block }}__right">
        <div class="{{ $block }}__info">
            <div class="{{ $block }}__header">
                <p class="c-white c-bg-purple c-bold {{ $block }}__date" itemprop="startDate"
                    content="{{ $date }}">
                    {!! $date !!}
                </p>
                @if ($time)
                    <p class="{{ $block }}__time" itemprop="eventTime">
                        {!! $time !!}
                    </p>
                @endif
            </div>
            <p class="{{ $block }}__city" itemprop="location" itemscope itemtype="https://schema.org/Place">
                {{ $city['name'] }}
            </p>
            <p class="c-font-subtitle c-black {{ $block }}__title" itemprop="name">
                {!! $title !!}
            </p>
            <div class="c-black {{ $block }}__desc">
                @if ($description)
                    {!! $description !!}
                @endif
            </div>
        </div>
        @if ($link != '' && $link != null)
            <a href="{{ $link }}" class="c-link {{ $block }}__link" rel="nofollow">
                <span>{{ $common['other']['link']['caption'] }}</span><span>{!! $common['other']['link']['icon'] !!}</span>
            </a>
        @endif
    </div>
</div>
