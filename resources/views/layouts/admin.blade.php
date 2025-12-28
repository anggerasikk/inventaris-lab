<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    @auth
        <meta name="user-theme" content="{{ Auth::user()->theme_preference ?? 'light' }}">
    @endauth
    <title>@yield('title', 'Dashboard Admin')</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/darkmode.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gaya dasar gradien, akan dipindahkan ke app.css jika menggunakan aset */
        .hero-bg {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            min-height: 100vh;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="admin-top-controls position-absolute top-0 end-0 p-2">
        @auth
            @include('components.theme-toggle')
        @endauth
    </div>

    <div class="hero-bg">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/darkmode.js') }}"></script>
</body>
</html>