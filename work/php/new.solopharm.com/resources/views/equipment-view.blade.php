@extends('layouts.default')

@section('content')
	{!!
		$templates->renderBlock('production/production-equipment', [
			'pageData' => $pageData,
			'eq' => $eq,
			'eqP' => $eqP
		])
	!!}
@endsection
