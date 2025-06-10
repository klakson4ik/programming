@extends('layouts.app')
@section('content')
    <div class="{{ $block }}" style="background-image: url({{ $img }})">
        <div class="c-container {{ $block }}__container">
            <h1 class="c-h2 {{ $block }}__title">
                {!! $title !!}
            </h1>
            <div class="{{ $block }}__form">
                @include('form.default', $formData)
            </div>
        </div>
        @include('component.modal', ['id' => 'success'])
    </div>
    <div class="{{ $block }}__preloader">
        {!! getCommonIcon('preloader') !!}
    </div>
@endsection
