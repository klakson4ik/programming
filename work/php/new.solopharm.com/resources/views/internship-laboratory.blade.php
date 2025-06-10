@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('internship-laboratory/internship-laboratory-page', [
			'page' => $page,
			'laboratories' => $laboratories
		])
	!!}
@endsection
