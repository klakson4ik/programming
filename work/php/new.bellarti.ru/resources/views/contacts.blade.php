@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title }}</h1>
        <div class="c-indent-bottom {{ $block }}__top-info">
            @include('pages.contacts.top-info', $topInfo)
        </div>
        <div class="c-rel {{ $block }}">
            @include('component.pagination.side', ['data' => $pagination])
            <div class="c-indent-bottom {{ $block }}__main">
                @include('pages.contacts.production', $production)
            </div>

            <div class="c-indent-bottom {{ $block }}__main">
                @include('pages.contacts.main-office', $mainOffice)
            </div>

            <div class="c-rel c-indent-bottom {{ $block }}__main">
                @include('pages.contacts.representatives', $representatives)
                @include('component.trash', [
                    'img' => $common['trash-2'],
                    'top' => '-30%',
                    'right' => '20%',
                ])
            </div>

            <div class="c-indent-bottom {{ $block }}__ymap">
                @include('pages.patient.ymap', $ymap)
                <div class="c-container replace-container {{ $block }}__ymap-infos"></div>
            </div>
            <div class="c-indent-bottom {{ $block }}__main c-rel">
                @include('pages.contacts.partners', $partners)
                @include('component.trash', [
                    'img' => $common['trash-1'],
                    'top' => '40%',
                    'left' => '0',
                ])
            </div>
        </div>
    </div>
@endsection
