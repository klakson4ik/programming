@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('production/rnd-page', ['pageData' => $pageData]) !!}
@endsection
