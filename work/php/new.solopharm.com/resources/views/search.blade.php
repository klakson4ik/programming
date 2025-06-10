@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('search/search-page', [
        'data' => $result,
        'isEmpty' => $isEmpty,
        'count' => $count
    ]) !!}
@endsection
