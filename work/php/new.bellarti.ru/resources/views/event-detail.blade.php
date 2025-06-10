@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title ?? 'Bellarti' }}</h1>
        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.news.main', $main)
        </div>
        <div class="c-container b-content-event__column">
            <div class="b-content-event__left {{ $block }}__currentEvents">
                @include('pages.event-detail.current-event', $currentEvents)
                <div class="{{ $block }}__wrapper-currentNews">
                    @include('pages.event-detail.other-events', $otherEvents)
                </div>
            </div>

            <aside class="b-content-event__right {{ $block }}__right">
                @include('component.calendar.main', $common['calendar'])
            </aside>
        </div>
    </div>
@endsection
