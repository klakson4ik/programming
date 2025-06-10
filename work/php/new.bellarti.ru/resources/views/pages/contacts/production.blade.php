<section id="{{ $block }}" class="c-container {{ $block }}">
    <div class="{{ $block }}__wrapper">
        <div class="{{ $block }}__column-left" itemscope itemtype="http://schema.org/Organization">
            <div class="{{ $block }}__content">
                <h2 class="c-purple-dark {{ $block }}__title">{!! $title !!}</h2>
                <div class="{{ $block }}__desc">
                    <p class="c-font-subtitle {{ $block }}__subtitle">{{ $production }}</p>
                    <p class="{{ $block }}__geo" itemscope itemprop="streetAddress"
                        itemtype="http://schema.org/PostalAddress">{{ $geo1 }}</p>
                </div>
            </div>
            <div class="{{ $block }}___office">
                <div class="{{ $block }}__desc">
                    <p class="c-font-subtitle {{ $block }}__subtitle">{{ $office }}</p>
                    <p class="{{ $block }}__geo" itemscope itemprop="streetAddress"
                        itemtype="http://schema.org/PostalAddress">{{ $geo2 }}</p>
                </div>
                <p class="{{ $block }}__email">{!! $text !!}
                    <a href="mailto: {{ $email }}" class="c-purple-dark"
                        itemprop = "email">{{ $email }}</a>
                </p>
            </div>
        </div>
        <div class="{{ $block }}__column {{ $block }}__column--right">
            <img src="{{ $img }}" alt="{{ $title }}">
        </div>
    </div>
</section>
