@extends('layouts.main-page')

@section('content')
	{!!
		$templates->renderBlock('main/main-page', [
			'linkUrl' => $linkUrl,
			'linkText' => $linkText,
			'titleImg' => $titleImg,
			'block2' => $block2,
			'block3' => $block3,
			'block4' => $block4,
			'block5' => $block5,
			'block6' => $block6,
			'block6Text' => $block6Text,
			'titles' => $titles,
			'product' => $product,
		])
	!!}
@endsection
