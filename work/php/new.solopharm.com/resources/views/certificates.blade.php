@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('partners/partners-certificates', [
			'header' => $header,
			'certificates' => $certificates
		])
	!!}
@endsection
