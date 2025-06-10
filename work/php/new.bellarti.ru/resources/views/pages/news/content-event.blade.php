<section id="{{ $block }}" class="c-container {{ $block }}">
    <div class="{{ $block }}__tabs">
        @include('pages.news.tabs')
    </div>
    <div class="{{ $block }}__column">
        <div class="{{ $block }}__left">
			@include('pages.news.cards-event')
        </div>
        <aside class="{{ $block }}__right">
            @include('component.calendar.main', $common['calendar'])
        </aside>
    </div>
</section>
