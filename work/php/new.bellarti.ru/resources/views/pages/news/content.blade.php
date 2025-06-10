<section id="{{ $block }}" class="c-container {{ $block }}">
    <div class="{{ $block }}__tabs">
        @include('pages.news.tabs')
    </div>
    @if (count($cards) > 0)
        <div class="{{ $block }}__cards cards">
            @foreach ($cards as $card)
                <div class="{{ $block }}__card">
                    @include('pages.news.card', $card)
                </div>
            @endforeach
        </div>
    @endif
    @if ($isMore)
        <div class="{{ $block }}__more">
            <button class="c-link more" data-active="{{ $active }}">
                {!! $more !!}
            </button>
        </div>
    @endif
</section>
