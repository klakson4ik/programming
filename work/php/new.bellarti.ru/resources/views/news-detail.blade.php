@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title ?? 'Bellarti' }}</h1>
        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.news.main', $main)
        </div>
        <div class="c-indent-bottom c-rel {{ $block }}__content">
            @include('pages.news-detail.text', $text)
            @include('component.trash', [
                'img' => $common['trash-3'],
                'top' => '0',
                'right' => '36.9rem',
            ])
            @include('component.trash', [
                'img' => $common['trash-2'],
                'bottom' => '-24rem',
                'right' => '0',
            ])
        </div>

        <div class="c-indent-bottom c-rel {{ $block }}__blog">
            @include('pages.patient.blog', $blog)
        </div>

        <div class="c-indent-bottom c-rel {{ $block }}__product c-purple-dark">
            @include('pages.home.product', $otherProduct)
            @include('component.trash', [
                'img' => $common['trash-1'],
                'bottom' => '0',
                'left' => '0',
            ])
        </div>

        <div class="c-indent-bottom {{ $block }}__ymap">
            @include('pages.patient.ymap', $ymap)
            <div class="c-container replace-container {{ $block }}__ymap-infos"></div>
        </div>

    </div>
@endsection
