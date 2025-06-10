@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('gallery/gallery-detail', [
			'gallery' => $gallery
		])
	!!}
@endsection
