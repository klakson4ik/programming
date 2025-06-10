@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('club/club', [
			'page' => $page,
			'arrangements' => $arrangements,
			'premises' => $premises
		])
	!!}
@endsection
