<div class="b-calendar">
    <div class="b-calendar__headers">
        @foreach ($data['header'] as $header)
            <p class="c-gray b-calendar__header">
                {!! $header !!}
            </p>
        @endforeach
    </div>
    <div class="b-calendar__items">
        @foreach ($data['days'] as $day)
            <div class="c-border-purple-light-very b-calendar__item {{ $day['out'] ? 'b-calendar__item--out' : '' }} {{ !$day['events'] ? '' : 'b-calendar__item--event' }} {{ $day['passed'] ? 'b-calendar__item--passed' : '' }} {{ $day['current'] ? 'b-calendar__item--current' : '' }}"
                data-city-id="">
                <p class="c-bold b-calendar__number">
                    {!! $day['number'] !!}
                </p>
                @if ($day['events'])
                    <div class="b-calendar__events">
                        <div class="b-calendar__event" data-city-id="{{ $day['events'][0]['city']['id'] }}">
                            @if ($day['events'][0]['time'])
                                <p class="b-calendar__time">
                                    {!! $day['events'][0]['time'] !!}
                                </p>
                            @endif
                            @if ($day['events'][0]['title'])
                                <p class="b-calendar__title">
                                    {!! $day['events'][0]['title'] !!}
                                </p>
                            @endif
                        </div>
                        @if (count($day['events']) > 1)
                            <p class="c-since-sm b-calendar__count">
                                {!! $day['events-count'] !!}
                            </p>
                        @endif
                        <div class="c-bg-white b-calendar__dropdown">
                            <p class="c-bold b-calendar__number">
                                {!! $day['number'] . ' ' . $day['month'] !!}
                            </p>
                            @foreach ($day['events'] as $event)
                                <a href="{{ getLink('/cosmetology/' . $event['code']) }}" class="b-calendar__event"
                                    data-city-id="{{ $event['city']['id'] }}">


                                    <div class="c-till-md b-calendar__close-icon">
                                        {!! getCommonIcon('arrow-45') !!}
                                    </div>
                                    @if ($event['time'])
                                        <p class="b-calendar__time">
                                            {!! $event['time'] !!}
                                        </p>
                                    @endif
                                    @if ($event['title'])
                                        <p class="b-calendar__title">
                                            {!! $event['title'] !!}
                                        </p>
                                    @endif
                                    @if ($event['description'])
                                        <div class="b-calendar__desc">
                                            {!! $event['description'] !!}
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
