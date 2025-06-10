<meta charset="UTF-8" />
<title>{!! $seo_title !!}</title>
<meta name="description" content="{!! $seo_description !!}">
<meta name="keywords" content="{!! $seo_keywords !!}">

<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta content="telephone=no" name="format-detection" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

@include('./common/includes/ymetic')

@include('./common/includes/og')

@vite(['resources/style/' . $asset . '.scss'])
@vite(['resources/script/' . $asset . '.js'])

<link rel="icon" type="image/x-icon" href="/favicon.ico" />

@include('./common/favicon')

<meta name="msapplication-TileColor" content="#7843E9">
<meta name="theme-color" content="#7843E9">
