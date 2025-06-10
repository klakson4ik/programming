@php
	$block = 'b-cards-event';
@endphp
<div class="{{ $block }}">
    <div class="c-indent-bottom">
        <p class="c-h3 c-purple-dark {{ $block }}__subtitle ">
            {!! $common['other']['future'] !!}
        </p>
        @if (count($cards['future']) > 0)
            <div class="{{ $block }}__cards {{ $block }}__cards--future">
                @foreach ($cards['future'] as $card)
                    <div class="{{ $block }}__card">
                        @include('pages.news.card-event', $card)
                    </div>
                @endforeach
            </div>
        @else
            <p class="c-font-subtitle {{ $block }}__future-discl">
                {!! $common['other']['discl'] !!}
            </p>
        @endif
    </div>
    @if (count($cards['past']) > 0)
        <p class="c-h3 c-purple-dark {{ $block }}__subtitle ">
            {!! $common['other']['past'] !!}
        </p>
        <div class="{{ $block }}__cards {{ $block }}__cards--past">
            @foreach ($cards['past'] as $card)
                <div class="{{ $block }}__card">
                    @include('pages.news.card-event', $card)
                </div>
            @endforeach
        </div>
    @endif
</div>
