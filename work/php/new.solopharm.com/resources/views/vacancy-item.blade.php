@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('vacancy/vacancy-item', [
		'vacancy' => $vacancy,
		'socialShare' => $socialShare,
		'respond' => $respond,
		'page' => $page
	]) !!}
@endsection
