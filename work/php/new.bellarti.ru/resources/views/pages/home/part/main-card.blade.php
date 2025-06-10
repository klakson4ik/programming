<div class="{{ $block }}">
    <div class="{{ $block }}__picture">
        @include('component.picture', $img)
    </div>
    @if (isset($title) || isset($description) || isset($svg))
        <div class="c-container {{ $block }}__info">
            @isset($svg)
                <div class="{{ $block }}__icon">
                    {!! getStorageIcon($svg) !!}
                </div>
            @endisset
            @isset($title)
                <p class="c-white c-font-subtitle {{ $block }}__title">
                    {!! $title !!}
                </p>
            @endisset
            @isset($description)
                <p class="c-white {{ $block }}__desc">
                    {!! $description !!}
                </p>
            @endisset
        </div>
    @endif
</div>
