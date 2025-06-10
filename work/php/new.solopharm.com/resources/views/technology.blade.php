@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('technology/technology', [
		'page' => $page,
		'technologies' => $technologies,
		'content' => $content,
		'trades' => $trades
	]) !!}
@endsection
