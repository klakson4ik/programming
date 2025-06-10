@extends('layouts.app')
@section('content')
    <section class="c-rel c-container {{ $block }}">
        <div class="{{ $block }}__left-side">
            @include('component.picture', $error['data'])
        </div>
        <div class="{{ $block }}__right-side">
            <h1 class="c-purple-dark {{ $block }}__title">{!! $error['title'] !!}</h1>
            <h2 class="c-purple-dark {{ $block }}__subtitle">{!! $error['subtitle'] !!}</h2>
            <p class="white {{ $block }}__desc">{!! $error['desc'] !!}</p>
            @include('component.link', $error['data'])
        </div>
    </section>
@endsection
