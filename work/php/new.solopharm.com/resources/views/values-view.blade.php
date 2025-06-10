@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('production/values-page', [
		'pageData' => $pageData,
		'chronology' => $chronology,
		'achievement' => $achievement,
		'country' => $country,
		'today' => $today,
		'progress' => $progress
	]) !!}
@endsection
