@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('press/news-detail', [
        'title' => $item->title,
        'text' => $item->text,
        'tag' => $item->tag,
        'tag_url' => $item->tag_url,
        'date' => strtotime($item->date),
        'months' => $months,
        'socialShare' => $socialShare,
    ]) !!}
@endsection
