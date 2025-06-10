<div class="{{ $block }}">
    <div class="{{ $block }}__img">
        <img src="{{ $img }}" alt="{{ $alt_for_img ?? $name }}" width="275" height="338" title="{{ $title_for_img ?? $name }}">
    </div>
    <p class="c-purple-light c-uppercase {{ $block }}__name">
        {!! $name !!}
    </p>
    @if ($description)
        <div class="c-gray {{ $block }}__desc">
            {!! $description !!}
        </div>
    @endif
</div>
