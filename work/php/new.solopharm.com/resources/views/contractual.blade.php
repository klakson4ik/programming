@extends('layouts.default')

@section('content')
    {!! 
        $templates->renderBlock('partners/partners-contractual', [
            'header' => $header,
            'img' => $img,
            'desc' => $desc,
            'block1' => $block1,
            'block2' => $block2,
            'block3' => $block3,
            'block4' => $block4
        ])
    !!}
@endsection
