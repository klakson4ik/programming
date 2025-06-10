<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.includes.head')

<body class="b-wrapper b-wrapper--main">

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
        <main class="b-page">
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
    @if(!isset($_COOKIE['closePopup']) && isset($popupData))
        <div class="b-wrapper__popup">
            {!! $templates->renderBlock('main/main-popup', $popupData) !!}
        </div>
    @endif
</body>

</html>
