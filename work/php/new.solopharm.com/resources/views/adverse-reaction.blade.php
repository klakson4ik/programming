@extends('layouts.default')

@section('content')
    {!! $templates->renderBlock('adverse-reaction/reaction-page', [
        'page' => $page,
        'form' => $form
    ]) !!}
@endsection
