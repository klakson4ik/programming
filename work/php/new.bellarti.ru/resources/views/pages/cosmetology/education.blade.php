<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark">{!! $title !!}</h2>
    <div class="{{ $block }}__row">
        @if (!empty($cities))
            <div class="c-bg-purple-light-very {{ $block }}__column {{ $block }}__column--city">
                @include('component.select', [
                    'items' => $cities,
                    'selected' => $selects['city']['selected'],
                    'icon' => $selects['city']['arrow'],
                    'event' => 'education-city',
                ])
            </div>
        @endif
        <div class="{{ $block }}__column {{ $block }}__column--date">
            <div class="{{ $block }}__date-action">
                <button class="c-trans-bg {{ $block }}__prev">{!! $selects['city']['arrow'] !!}</button>
                <button class="c-trans-bg {{ $block }}__next">{!! $selects['city']['arrow'] !!}</button>
            </div>
            <div class="{{ $block }}__date-select">
                @include('component.select', [
                    'items' => $selects['date']['items'],
                    'selected' => $selects['date']['selected'],
                    'icon' => $selects['date']['arrow'],
                    'event' => 'education-date',
                ])
            </div>
        </div>
    </div>
    <div class="{{ $block }}__calendar">
        <div class="replace-content">
            {!! $calendar !!}
        </div>
    </div>
</section>
