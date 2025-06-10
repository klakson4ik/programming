@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title }}</h1>
        <div class="c-container wrapper__breadcrumbs">
            @include('common.breadcrumbs')
        </div>

        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.cosmetology.main', $main)
        </div>
        <div class="c-rel">
            @include('component.pagination.side', ['data' => $pagination])
            <div class="c-indent-bottom {{ $block }}__eco">
                @include('pages.cosmetology.eco', $eco)
            </div>
            <div class="c-indent-bottom {{ $block }}__detail">
                @include('pages.cosmetology.detail', $detail)
            </div>
            <div class="c-indent-bottom c-rel {{ $block }}__product">
                @include('pages.home.product', $product)
                @include('component.trash', [
                    'img' => $common['trash-1'],
                    'top' => '-15.6rem',
                    'left' => '0',
                ])
            </div>
            <div class="c-indent-bottom {{ $block }}__protocol">
                @include('pages.cosmetology.protocol-list', $protocol)
            </div>
            <div class="c-indent-bottom {{ $block }}__publications">
                @include('pages.detail-product.publications', $publications)
            </div>
            <div class="c-indent-bottom {{ $block }}__example">
                @include('pages.cosmetology.example', $example)
            </div>
            <div class="c-indent-bottom c-rel {{ $block }}__expert">
                @include('pages.cosmetology.expert', $expert)
                @include('component.trash', [
                    'img' => $common['trash-2'],
                    'top' => '-6rem',
                    'right' => '0',
                ])
            </div>
            <div class="c-indent-bottom {{ $block }}__education">
                @include('pages.cosmetology.education', $education)
            </div>
        </div>
    </div>
@endsection
