<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Poll Maker')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="d-flex flex-column sticky-footer-wrapper">
    <div id="app" class="container mb-5">
        <main class="py-5">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
