@if (Request::route())
    {!! Request::route()->getName() == '404' ? header('Status: 404 Not Found') : '' !!}
@endif
@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('errors/error-404', []) !!}
@endsection
