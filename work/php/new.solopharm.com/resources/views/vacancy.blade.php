@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('vacancy/vacancy', [
        'page' => $page,
        'vacancies' => isset($vacancies) ? $vacancies : $vacancies,
        'counts' => $counts
    ]) !!}
@endsection
