@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('production/sup-plant-page', [
		'pageData' => $pageData,
		'supdSys' => $supdSys
	]) !!}
@endsection
