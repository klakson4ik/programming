@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('soft-form-plant/page', [
		'page' => $page,
	]) !!}
@endsection
