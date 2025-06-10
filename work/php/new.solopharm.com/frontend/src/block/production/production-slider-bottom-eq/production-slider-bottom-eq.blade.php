<div class="{{ $block }}">
    <div class="{{ $block->elem('nav') }}">
        <div class="{{ $block->elem('nav-action') }}">
            <span class="{{ $block->elem('nav-left') }}">
                {!! $renderer->renderBlock('common/arrow', [
                    'type' => 'button',
                    'left' => true,
                ]) !!}
            </span>
            <span class="{{ $block->elem('nav-right') }}">
                {!! $renderer->renderBlock('common/arrow', [
                    'type' => 'button',
                ]) !!}
            </span>
        </div>
    </div>
    <div class="slider-eq-bottom">
        <div class="swiper-wrapper">
            @foreach ($eq as $items)
                <div class="swiper-slide">
                    <img title="{{ $items['title'] }}" alt="{{ __('pages.photo') }} {{ $items['title'] }}"
                        src="{{ asset('storage/' . $items['img']) }}" alt="">
                    <div class="info swiper-no-swiping">

                        <h2 class="c-h2">{{ $items['title'] }}</h2>
                        <p>
                            <b>{{ __('pages.equipment.manufacturer') }}:</b>
                            <br>
                            <span>{!! $items['manufacturer'] !!}</span>
                        </p>
                        <p>
                            <b>{{ __('pages.equipment.performance') }}:</b>
                            <br>
                            <span>{!! $items['performance'] !!}</span>
                        </p>
                        <p>
                            <b>{{ __('pages.equipment.packaging_type') }}:</b>
                            <br>
                            <span>{!! $items['form'] !!}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
