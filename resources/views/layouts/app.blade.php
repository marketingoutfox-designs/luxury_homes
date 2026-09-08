<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Luxury Homes — thoughtfully designed residences built on vision and values.">
    <title>@yield('title', 'Luxury Homes')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="@yield('bodyClass')">
    @include('partials.header')
    <main>@yield('content')</main>
    @unless(View::hasSection('hideFooter'))
        @include('partials.footer')
    @endunless
    @stack('scripts')
</body>
</html>
