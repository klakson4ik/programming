<div class="{{ $block }}">

    <h2 class="c-h2">{!! $pageData->block_5_title !!}</h2>

    <!-- Slider main container -->
    <div class="swiperSolnow">
        
        <div class="swiper-wrapper">
            @foreach ($today as $item)
                <div class="swiper-slide" id="index{{ $loop->index }}" data-title="{{ $item->title }}"
                    data-text="{{ $item->text }}">
                    <img title="{{ $item->title }}" alt="{{ __('pages.photo') }} {{ $item->title }}"
                        src="{{ asset('storage/' . $item['img']) }}">
                </div>
            @endforeach
        </div>
        <div class="navinfo">
            <div class="text">
                <h3 class="c-h3"></h3>
                <p>
                </p>
                <div class="link"></div>
            </div>
        </div>
    </div>
</div>
