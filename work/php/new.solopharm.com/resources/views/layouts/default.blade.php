<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.includes.head')

<body class="b-wrapper @if (Request::route()) {!! Request::route()->getName() == 'main' ? 'b-wrapper--main' : '' !!} @endif">

    @if (env('GTM') == 'true')
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2GDVPR" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    <div class="b-wrapper__header">
        @include('layouts.includes.header')
    </div>
    <div class="b-wrapper__content">
        @if (Request::route() && Request::route()->getName() !== 'main' && Request::route()->getName() !== '404')
            @include('layouts.includes.breadcrumbs')
        @endif
        <main class="b-page c-container">
            @yield('content')
        </main>
    </div>
    <div class="b-wrapper__footer">
        @include('layouts.includes.footer')
    </div>
    @if (!isset($_COOKIE['acceptCookie']))
        <div class="b-wrapper__cookie">
            {!! $templates->renderBlock('common/cookie') !!}
        </div>
    @endif
</body>

</html>
