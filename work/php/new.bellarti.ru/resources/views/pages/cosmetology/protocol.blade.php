@foreach ($sliders as $slider)
    <div class="{{ $block }}__item item {{ $slider['classHelper'] }}">
        <div class="{{ $block }}__header">
            <p class="c-trans-color c-purple-dark c-h4 {{ $block }}__caption">
                {!! $slider['title'] !!}
            </p>
            <div class="{{ $block }}__arrow">
                @include('component.arrow-select')
            </div>
        </div>
        <div class="{{ $block }}__dropdown dropdown">
            <div class="{{ $block }}__text">
                @include('component.slider.default', $slider)
            </div>
        </div>
    </div>
@endforeach
