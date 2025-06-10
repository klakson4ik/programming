@extends('layouts.app')
@section('content')
    <div class="{{ $block }} c-main-indent-top">
        <h1 class="c-h1-hidden">{{ $main_title }}</h1>
        <div class="c-container">
            @include('common.breadcrumbs')
        </div>

        <div class="c-rel">
            @include('component.pagination.side', ['data' => $pagination])
            <div class="c-indent-bottom {{ $block }}__detail">
                @include('pages.detail-product.detail', $main)
            </div>

            @if (count($techniques['slider']['cards']) > 0)
                <div class="{{ $block }}__introduction-techniques">
                    @include('pages.detail-product.introduction-techniques', $techniques)
                </div>
            @endif

            @if (strlen($videoInstructions['html']) >= 10)
                <div class="c-indent-bottom {{ $block }}__video c-rel">
                    @include('pages.detail-product.video', $videoInstructions)
                    @include('component.trash', [
                        'img' => $common['trash-1'],
                        'top' => '-30rem',
                        'right' => '0',
                    ])
                </div>
            @endif

            <div class="c-indent-bottom c-indent-top {{ $block }}__publications">
                @include('pages.detail-product.publications', $publications)
            </div>

            <div class="c-indent-bottom c-rel {{ $block }}__product c-purple-dark">
                @include('pages.home.product', $otherProduct)
            </div>
        </div>
    </div>
@endsection
