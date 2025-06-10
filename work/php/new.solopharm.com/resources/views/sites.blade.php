@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('sites/sites-page', [
		'page' => $page,
		'sites' => $sites
	]) !!}
@endsection
