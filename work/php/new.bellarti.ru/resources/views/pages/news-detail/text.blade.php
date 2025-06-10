<section id="{{ $block }}" class="c-container {{ $block }}" itemscope itemtype="http://schema.org/Article">
    <div class="{{ $block }}__wrapper c-rel">
        @isset($slider)
            @if (count($slider['cards']) > 0)
                <div id="{{ $block }}" class="{{ $block }}">
                    @include('component.slider.default', $slider)
                </div>
            @endif
        @endisset
        <div class="{{ $block }}__wrapper">
            <div class="{{ $block }}__text" itemprop="articleBody">{!! $text['info']['description'] !!}</div>
            <p class="c-gray-light {{ $block }}__date" itemprop="datePublished">{!! $text['info']['date'] !!}</p>
        </div>
    </div>
    @include('component.social-share')
</section>
