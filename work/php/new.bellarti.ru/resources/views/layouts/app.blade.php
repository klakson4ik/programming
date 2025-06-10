<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" prefix="og: https://ogp.me">

<head>
    @include('common.head')
</head>

<body class="wrapper">
    <header class="wrapper__header">
        @include('common.header')
    </header>
    <main id="wrapper" class="wrapper__content">
        @yield('content')
    </main>
    <div class="wrapper__footer">
        @include('common.footer')
    </div>
    @if (!isset($_COOKIE['acceptCookie']))
        @include('component.cookie.cookie')
    @endif
</body>

</html>
