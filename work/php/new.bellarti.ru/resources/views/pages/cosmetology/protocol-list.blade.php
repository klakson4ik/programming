@if (isset($sliders))
    <section id="{{ $block }}" class="{{ $block }}">
        <div class="c-container {{ $block }}__container">
            <h2>{!! $title !!}</h2>
            <div class="{{ $block }}__items">
                @include('pages.cosmetology.protocol')
            </div>
        </div>
    </section>
@endif
