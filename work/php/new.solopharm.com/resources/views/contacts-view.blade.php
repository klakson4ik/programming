@extends('layouts.default')
<script src="https://api-maps.yandex.ru/2.1/?lang={!! app()->getLocale() !!}"></script>
@section('content')
    {!! $templates->renderBlock('contacts/contacts-container', [
        'data' => $ContData,
        'local' => $local,
    ]) !!}
@endsection
