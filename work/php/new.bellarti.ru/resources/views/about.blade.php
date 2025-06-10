@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title }}</h1>
        <div class="c-container wrapper__breadcrumbs">
            @include('common.breadcrumbs')
        </div>

        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.home.main', $topSlider)
        </div>
        <div class="c-rel">
            @include('component.pagination.side', ['data' => $pagination])

            <div class="c-indent-bottom {{ $block }}__facts">
                @include('pages.about.facts', $facts)
            </div>

            <div class="c-indent-bottom {{ $block }}__info">
                @include('pages.about.more-info', $todayData)
            </div>

            <div class="c-indent-bottom {{ $block }}__destinations">
                @include('pages.about.popular-destinations', $popularDestinations)
            </div>

            <div class="c-indent-bottom {{ $block }}__develop">
                @include('pages.about.research-develop', $researchDevelop)
            </div>

            <div class="{{ $block }}__sterilization">
                @include('pages.about.sterilization', $sterilization)
            </div>

            <div class="c-indent-bottom {{ $block }}__substances">
                @include('pages.about.substances', $substances)
            </div>

            <div class="c-indent-bottom {{ $block }}__control c-rel">
                @include('pages.about.quality-control', $qualityControl)
                @include('component.trash', [
                    'img' => $common['trash-1'],
                    'top' => '0',
                    'right' => '0',
                ])
            </div>

            <div class="c-indent-bottom {{ $block }}__big-video c-rel">
                @include('pages.about.big-video', $bigVideo)
                @include('component.trash', [
                    'img' => $common['trash-2'],
                    'top' => '25%',
                    'left' => '0',
                ])
            </div>
        </div>
    </div>
@endsection
