@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('supplier/supplier-page', [
		'page' => $page
	]) !!}
@endsection
