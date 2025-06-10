@extends('layouts.app')
@section('content')
    <section class="c-rel c-container {{ $block }}">
        <h1>{{ $error['title'] }}</h1>
        <h2>{{ $error['subtitle'] }}</h2>
    </section>
@endsection
