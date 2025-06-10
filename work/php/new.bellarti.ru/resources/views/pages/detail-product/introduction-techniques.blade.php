<section class="{{ $block }}" id="{{ $block }}" style="background-image: url('{{ $bg }}')">
    <div class="c-container {{ $block }}__wrapper">
        <div class="{{ $block }}__main">
            <h2 class="{{ $block }}__title">{{ $title }}</h2>
            <h4 class="c-purple-dark c-extra-light {{ $block }}__subtitle">{!! pickFirstWord($name, 'c-bold') !!}</h4>
            <div class="{{ $block }}__methods">
                @include('component.slider.default', $slider)
            </div>
        </div>
    </div>
</section>
