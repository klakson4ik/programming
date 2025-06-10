@extends('layouts.default')

@section('content')
	{!! 
		$templates->renderBlock('internship/internship-page', [
			'page' => $page
		])
	!!}
@endsection
