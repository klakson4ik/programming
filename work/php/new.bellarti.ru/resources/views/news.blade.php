@extends('layouts.app')
@section('content')
    <h1 class="c-h1-hidden">{{ $main_title }}</h1>
    <div class="c-content-overflow-clip {{ $block }}">
        <div class="c-indent-bottom {{ $block }}__main">
            @include('pages.news.main', $main)
        </div>
        <div class="c-indent-bottom {{ $block }}__content">
            @include('pages.news.' . $template, $content)
            @include('component.trash', [
                'img' => $trash[0],
                'top' => '91rem',
                'left' => '0',
            ])
        </div>
    </div>
@endsection
