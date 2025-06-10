@extends('layouts.default')

@section('content')
    {!! 
        $templates->renderBlock('production/biotech-page', [
            'eq' => $eq,
            'pageData' => $pageData
        ])
    !!}
@endsection
