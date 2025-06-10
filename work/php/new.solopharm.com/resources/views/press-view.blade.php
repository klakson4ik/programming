@extends('layouts.default')

@section('content')
	{!! 
		$templates->renderBlock('press/press-list', [
			'pressPage' => $pressPage,
			'press' => $press,
			'months' => $months
		])
	!!}
@endsection
