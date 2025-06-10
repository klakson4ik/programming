@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('product-item/product-item', [
			'product' => $product,
			'trades' => $trades,
			'currentTrade' => $currentTrade,
			'socialShare' => $socialShare,
			'catalogPage' => $catalogPage,
			'links' => $links
		])
	!!}
@endsection
