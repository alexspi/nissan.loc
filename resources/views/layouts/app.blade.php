<!DOCTYPE html>
<html lang="en">
<head>
    @include('header.head')
    {{--@yield('header.header_styles')--}}

</head>
<body id="app-layout">
    <!--[if lt IE 7]>
    <p class="browsehappy">Вы используете  <strong>слишком старый</strong> браузер. Пожалуйста <a href="http://browsehappy.com/">обновите ваш браузер</a> для нормального серфинга по современным сайтам.</p>
    <![endif]-->
    <header id="header" class="container px-0 mx-auto">
        @include('header.header')

    </header>
    <main class="container px-0 mx-auto">
        @yield('breadcrumbs')
        @yield('content')
    </main>
    @include('footer.foot_script')
    @yield('footer.before_scripts')
    @yield('footer_scripts')
    @yield('footer.after_scripts')
<footer class="container d-flex flex-row justify-content-between">
    @include('footer.footer')
</footer>

</body>
</html>
