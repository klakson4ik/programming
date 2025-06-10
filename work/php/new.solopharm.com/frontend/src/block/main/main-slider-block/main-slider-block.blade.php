<div class="{{ $block }}  c-container">

    <div class="{{ $block->elem('header') }}">
        <h2 class="c-h1">{{ $title }}</h2>
        <a href="{{ $linkUrl }}" class="c-link-main"><span class="{{ $block->elem('header-link')}}"> {{ $linkText }}</span> <img src="/images/icons/arr-r.svg"
                alt=""> </a>
    </div>
    <div class="{{ $block->elem('swiperArea') }}">
        <div class="nextb" onclick="testSlidePrev();">
            {!! $renderer->renderBlock('common/arrow', [
                'left' => true,
                'url' => '',
            ]) !!}
        </div>
        <div class="prewb" onclick="testSlideNext();">
            {!! $renderer->renderBlock('common/arrow', [
                'url' => '',
            ]) !!}
        </div>
         <div class="{{ $block->elem('nav') }}">
            <div class="{{ $block->elem('nav-action') }}">
                <span class="{{ $block->elem('nav-left') }}"  onclick="testSlidePrev();">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                        'left' => true,
                    ]) !!}
                </span>
                <span class="{{ $block->elem('nav-right') }}" onclick="testSlideNext();">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button'
                    ]) !!}
                </span>
            </div>
        </div>
        <div class="heverArea">
            <div class="swiperBWLeft">
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < count($block5); $i++)
                        <a href="/about/news/{{ $block5[$i]->urlSlug }}" class="swiper-slide">
                            <div>
                                <img loading="lazy" width="380px" height="480px"title="{{ $block5[$i]->title }}"
                                    alt="{{ __('pages.photo') }} {{ $block5[$i]->title }}"
                                    src="{{ asset('storage/' . $block5[$i]->img) }}">
                                <span>{{ date('d/m/y', strtotime($block5[$i]->date)) }}</span>
                            </div>
                            <p>
                                {{ $block5[$i]->title }}
                            </p>
                        </a>
                    @endfor
                </div>
            </div>
            <div class="swiperCenter">
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < count($block5); $i++)
                        <a href="/about/news/{{ $block5[$i]->urlSlug }}" class="swiper-slide">
                            <div>
                                <img loading="lazy" width="380px" height="480px" title="{{ $block5[$i]->title }}"
                                    alt="{{ __('pages.photo') }} {{ $block5[$i]->title }}"
                                    src="{{ asset('storage/' . $block5[$i]->img) }}">
                                <span>{{ date('d/m/y', strtotime($block5[$i]->date)) }}</span>
                            </div>
                            <p>
                                {{ $block5[$i]->title }}
                            </p>
                        </a>
                    @endfor
                </div>
            </div>
            <div class="swiperBWRight">
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < count($block5); $i++)
                        <a href="/about/news/{{ $block5[$i]->urlSlug }}" class="swiper-slide">
                            <div>
                                <img loading="lazy" width="380px" height="480px"title="{{ $block5[$i]->title }}"
                                    alt="{{ __('pages.photo') }} {{ $block5[$i]->title }}"
                                    src="{{ asset('storage/' . $block5[$i]->img) }}" alt="">
                                <span>{{ date('d/m/y', strtotime($block5[$i]->date)) }}</span>
                            </div>
                            <p>
                                {{ $block5[$i]->title }}
                            </p>
                        </a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
