<div class="b-content">
    @foreach ($days as $day)
        <p
            class="c-border-purple-light-very c-bold b-content__item {{ $day['out'] ? 'b-content__item--out' : '' }} {{ !$day['events'] ? '' : 'b-content__item--event' }} {{ $day['passed'] ? 'b-content__item--passed' : '' }} {{ $day['current'] ? 'b-content__item--current' : '' }}" data-day="{{ $day['day']}}">
            {!! $day['number'] !!}
        </p>
    @endforeach
</div>
