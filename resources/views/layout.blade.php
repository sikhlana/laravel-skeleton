<!doctype html>
<html id="{{ \Illuminate\Support\Str::slug(config('app.name')) }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('page-title') @yield('page-title') &mdash; @endif{{ config('app.name') }}</title>

    @stack('meta')

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fomantic-ui-css@2.8.7/semantic.min.css">
    <link rel="stylesheet" href="{{ asset(mix('css/vendor.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
</head>
<body class="{{ str_replace('.', ' ', $shared->viewName) }}">
    <div id="app">
        @yield('top-ctrl')
        @yield('contents')
        @yield('bottom-ctrl')

        <overlay></overlay>
        <notification></notification>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui-css@2.8.7/semantic.min.js"></script>

    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
</body>
</html>
