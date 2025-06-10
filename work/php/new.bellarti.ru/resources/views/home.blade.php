@extends('layouts.app')
@section('content')
    <div class="{{ $block }}">
        <h1 class="c-h1-hidden">{{ $main_title }}</h1>
        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.home.main', $main)
        </div>
        <div class="c-indent-bottom {{ $block }}__injection">
            @include('pages.home.injection', $injection)
        </div>
        <div class="c-indent-bottom {{ $block }}__magic">
            @include('pages.home.magic', $magic)
        </div>
        <div class="c-indent-bottom c-rel {{ $block }}__standard">
            @include('pages.home.standard', $standard)
            @include('component.trash', [
                'img' => $common['trash-1'],
                'bottom' => '-8.5rem',
                'right' => '0',
            ])
        </div>
        <div class="c-indent-bottom c-rel {{ $block }}__product">
            @include('pages.home.product', $product)
            @include('component.trash', [
                'img' => $common['trash-2'],
                'bottom' => '0',
                'left' => '0',
            ])
        </div>
    </div>
@endsection
