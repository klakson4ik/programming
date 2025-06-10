<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>{{ isset($meta['title']) ? $meta['title'] : __('pages.title') }}</title>
    <meta name="viewport" content="width=device-width">
    <meta name="format-detection" content="telephone=no">
    <meta name="yandex-verification" content="76aa72e72463dcd2" />
    <meta name="google-site-verification" content="DWq26BR6aabjgoHTCnB_MVwMdpiVGiPiYzVthToOC-o" /> 

    <script type="text/javascript" src="{{ $assets->jsUrl(isset($asset) ? $asset : 'common') }}"></script>

     @if (env('GTM') == 'true')
        @include('layouts.includes.seo-tools')
    @endif

    <link rel="stylesheet" type="text/css" href="{{ $assets->cssUrl(isset($asset) ? $asset : 'common') }}"
        media="all">

    @include('layouts.includes.favicon')

    <meta name="description"
        content="{{ isset($meta['description']) ? $meta['description'] : __('pages.description') }}">
    <meta name="keywords" content="{{ isset($meta['keywords']) ? $meta['keywords'] : __('pages.keywords') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    @include('layouts.includes.og')

    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>
