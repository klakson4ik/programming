@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('production/solid-plant-page', [
		'pageData' => $pageData,
		'sysData' => $sysData
	]) !!}
@endsection
