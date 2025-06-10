@extends('layouts.default')

@section('content')
	{!! $templates->renderBlock('product/product', [
		'page' => $page,
		'directions' => $directions,
		'products' => $products,
		'choiceFilters' => isset($choiceFilters) ? $choiceFilters : false,
		'directionIds' => isset($directionIds) ? $directionIds : false
	]) !!}
@endsection
