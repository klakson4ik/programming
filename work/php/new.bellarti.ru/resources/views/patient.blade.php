@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title }}</h1>
        <div class="c-container wrapper__breadcrumbs">
            @include('common.breadcrumbs')
        </div>

        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.patient.main', $main)
        </div>
        <div class="c-rel">
            @include('component.pagination.side', ['data' => $pagination])
            <div class="c-indent-bottom {{ $block }}__bio">
                @include('pages.patient.bio', $bio)
            </div>
            <div class="c-indent-bottom c-rel {{ $block }}__injection">
                @include('pages.home.injection', $injection)
                @include('component.trash', [
                    'img' => $common['trash-1'],
                    'bottom' => '16rem',
                    'left' => '0',
                ])
            </div>
            <div class="c-indent-bottom {{ $block }}__magic">
                @include('pages.patient.magic', $magic)
            </div>
            <div class="c-indent-bottom {{ $block }}__eco">
                @include('pages.patient.eco', $eco)
            </div>
            <div class="c-indent-bottom {{ $block }}__product">
                @include('pages.home.product', $product)
            </div>
            <div class="c-indent-bottom c-rel {{ $block }}__cosmetic">
                @include('pages.patient.cosmetic', $cosmetic)
                @include('component.trash', [
                    'img' => $common['trash-2'],
                    'bottom' => '-10rem',
                    'left' => '17rem',
                ])
            </div>
            <div class="c-indent-bottom c-rel {{ $block }}__example">
                @include('pages.cosmetology.example', $example)
                @include('component.trash', [
                    'img' => $common['trash-3'],
                    'bottom' => '-17rem',
                    'right' => '0',
                ])
            </div>
            <div class="c-indent-bottom {{ $block }}__faq">
                @include('pages.patient.faq', $faq)
            </div>
            <div class="c-indent-bottom c-rel {{ $block }}__blog">
                @include('pages.patient.blog', $blog)
                @include('component.trash', [
                    'img' => $common['trash-4'],
                    'bottom' => '-20rem',
                    'left' => '0',
                ])
            </div>
            <div class="c-indent-bottom {{ $block }}__ymap">
                @include('pages.patient.ymap', $ymap)
				<div class="c-container replace-container {{ $block }}__ymap-infos"></div>
            </div>
        </div>
    </div>
@endsection
