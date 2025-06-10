@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('production/liquid-plant-page', [
		'pageData' => $pageData
	]) !!}
@endsection
