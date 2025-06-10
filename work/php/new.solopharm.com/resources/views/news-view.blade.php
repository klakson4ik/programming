@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('press/news-list', [
        'pressPage' => $pressPage,
        'news' => $news,
    ]) !!}
@endsection
