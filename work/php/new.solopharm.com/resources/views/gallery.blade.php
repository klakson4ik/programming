@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('gallery/gallery', [
			'page' => $page,
			'sites' => $sites
		])
	!!}
@endsection
