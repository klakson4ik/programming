@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('partners/partners-markets', [
			'header' => $header,
			'data' => $data,
			'countries' => $countries,
			'partnersData' => $partnersData
		])
	!!}
@endsection
