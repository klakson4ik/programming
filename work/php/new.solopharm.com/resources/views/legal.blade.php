@extends('layouts.default')

@section('content')
	{!! 
		$templates->renderBlock('legal/legal', [
			'sites' => $sites,
			'page' => $page
		])
	!!}
@endsection
