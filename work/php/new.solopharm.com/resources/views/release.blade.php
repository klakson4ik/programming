@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('release/release', [
			'page' => $page,
			'forms' => $forms
		])
	!!}
@endsection
