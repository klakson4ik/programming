<section class="c-container {{ $block }}" id="{{ $block }}">
    <div class="c-rel {{ $block }}__picture">
        @include('component.picture', $img)
    </div>
    <div class="{{ $block }}__detail">
        <h2 class="c-purple-dark {{ $block }}__detail-title">{!! $title !!}</h2>
        <p class="{{ $block }}__detail-desc"> {!! $desc !!} </p>
    </div>
</section>
