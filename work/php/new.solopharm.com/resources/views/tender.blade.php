@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('tender/tender-page', [
		'page' => $page
	]) !!}
@endsection
